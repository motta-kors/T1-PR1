import os, sqlite3, secrets, hashlib, time
from pathlib import Path
from uuid import uuid4
from contextlib import contextmanager
import httpx
from fastapi import FastAPI, HTTPException, Header
from pydantic import BaseModel, Field

SERVICE = os.environ["SERVICE"]
KEY = os.environ["INTERNAL_SERVICE_KEY"]
DB = Path("/data") / f"{SERVICE}.db"
URL = {n: f"http://{n}:8000" for n in ("auth","inventory","orders","clients","payments")}
app = FastAPI(title=f"{SERVICE} (privado)", docs_url=None, redoc_url=None)

@contextmanager
def conn():
    DB.parent.mkdir(parents=True,exist_ok=True)
    c=sqlite3.connect(DB,timeout=15)
    c.row_factory=sqlite3.Row
    try:
        yield c
        c.commit()
    except:
        c.rollback()
        raise
    finally: c.close()

@app.on_event("startup")
def setup():
    with conn() as c:
        if SERVICE=="auth":
            c.execute("CREATE TABLE IF NOT EXISTS users(id TEXT PRIMARY KEY,email TEXT UNIQUE,hashed TEXT,salt TEXT,role TEXT)")
            c.execute("CREATE TABLE IF NOT EXISTS tokens(token_hash TEXT PRIMARY KEY,user_id TEXT,expires INTEGER)")
        if SERVICE=="clients": c.execute("CREATE TABLE IF NOT EXISTS profiles(user_id TEXT PRIMARY KEY,email TEXT,name TEXT)")
        if SERVICE=="inventory":
            c.execute("CREATE TABLE IF NOT EXISTS products(id TEXT PRIMARY KEY,name TEXT NOT NULL,price INTEGER NOT NULL,stock INTEGER NOT NULL,active INTEGER DEFAULT 1)")
            c.execute("CREATE TABLE IF NOT EXISTS reservations(order_id TEXT PRIMARY KEY,product_id TEXT NOT NULL,quantity INTEGER NOT NULL)")
        if SERVICE=="orders": c.execute("CREATE TABLE IF NOT EXISTS orders(id TEXT PRIMARY KEY,user_id TEXT NOT NULL,product_id TEXT NOT NULL,quantity INTEGER NOT NULL,total INTEGER NOT NULL,status TEXT NOT NULL)")
        if SERVICE=="payments": c.execute("CREATE TABLE IF NOT EXISTS payments(id TEXT PRIMARY KEY,order_id TEXT UNIQUE,amount INTEGER,status TEXT)")

def verify(key,user=None,role=None,admin=False):
    if not secrets.compare_digest(key or "",KEY): raise HTTPException(403,"Servicio no autorizado")
    if admin and (not user or role!="admin"): raise HTTPException(403,"Administrador requerido")

def obj(row): return dict(row) if row else None

def hash_password(pw,salt): return hashlib.scrypt(pw.encode(),salt=bytes.fromhex(salt),n=16384,r=8,p=1).hex()

async def request_internal(service,method,path,body=None,user="system",role="admin"):
    try:
        async with httpx.AsyncClient(timeout=5) as client:
            r=await client.request(method,URL[service]+path,json=body,headers={"x-internal-key":KEY,"x-user-id":user,"x-user-role":role})
    except httpx.RequestError: raise HTTPException(503,"Dependencia no disponible")
    if r.status_code>=400:
        try: msg=r.json().get("detail","Error del servicio")
        except ValueError: msg="Error del servicio"
        raise HTTPException(r.status_code,msg)
    return r.json() if r.content else None

class Register(BaseModel):
    email: str=Field(min_length=5,max_length=150)
    name: str=Field(min_length=1,max_length=100)
    password: str=Field(min_length=10,max_length=128)
class Login(BaseModel):
    email: str
    password: str
class Product(BaseModel):
    name: str=Field(min_length=1,max_length=120)
    price: int=Field(ge=0)
    stock: int=Field(ge=0)
    active: bool=True
class Order(BaseModel):
    product_id: str
    quantity: int=Field(ge=1,le=50)
class Reserve(BaseModel):
    order_id: str
    product_id: str
    quantity: int=Field(ge=1,le=50)

@app.get("/health")
def health(): return {"status":"ok","service":SERVICE}

if SERVICE=="auth":
    @app.post("/register",status_code=201)
    async def register(p:Register,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        email=p.email.strip().lower()
        if "@" not in email: raise HTTPException(422,"Correo no válido")
        uid,salt=str(uuid4()),secrets.token_hex(16)
        try:
            with conn() as c: c.execute("INSERT INTO users VALUES(?,?,?,?,?)",(uid,email,hash_password(p.password,salt),salt,"client"))
        except sqlite3.IntegrityError: raise HTTPException(409,"Correo registrado")
        try: await request_internal("clients","POST","/profiles",{"user_id":uid,"name":p.name,"email":email})
        except HTTPException:
            with conn() as c: c.execute("DELETE FROM users WHERE id=?",(uid,))
            raise
        return {"user_id":uid}

    @app.post("/login")
    def login(p:Login,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c:
            u=c.execute("SELECT * FROM users WHERE email=?",(p.email.strip().lower(),)).fetchone()
            if not u or not secrets.compare_digest(u["hashed"],hash_password(p.password,u["salt"])):
                raise HTTPException(401,"Credenciales inválidas")
            token=secrets.token_urlsafe(32)
            c.execute("INSERT INTO tokens VALUES(?,?,?)",(hashlib.sha256(token.encode()).hexdigest(),u["id"],int(time.time())+1800))
        return {"access_token":token,"token_type":"bearer","expires_in":1800}

    @app.post("/introspect")
    def introspect(p:dict,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        token=p.get("token","")
        with conn() as c:
            u=c.execute("SELECT u.id,u.role FROM tokens t JOIN users u ON u.id=t.user_id WHERE t.token_hash=? AND t.expires>?",(hashlib.sha256(token.encode()).hexdigest(),int(time.time()))).fetchone()
        return {"active":bool(u),"user_id":u["id"] if u else None,"role":u["role"] if u else None}

    @app.post("/logout")
    def logout(p:dict,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c: c.execute("DELETE FROM tokens WHERE token_hash=?",(hashlib.sha256(p.get("token","").encode()).hexdigest(),))
        return {"ok":True}

if SERVICE=="clients":
    @app.post("/profiles",status_code=201)
    def profile_create(p:dict,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c: c.execute("INSERT INTO profiles VALUES(?,?,?)",(p["user_id"],p["email"],p["name"]))
        return {"ok":True}

    @app.get("/me")
    def my_profile(x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        if not x_user_id: raise HTTPException(401,"Identidad requerida")
        with conn() as c: r=c.execute("SELECT * FROM profiles WHERE user_id=?",(x_user_id,)).fetchone()
        if not r: raise HTTPException(404,"Perfil no encontrado")
        return obj(r)

if SERVICE=="inventory":
    @app.get("/products")
    def list_products(x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c: return [obj(x) for x in c.execute("SELECT id,name,price,stock FROM products WHERE active=1 ORDER BY name LIMIT 100").fetchall()]

    @app.get("/products/{pid}")
    def get_product(pid:str,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c: p=c.execute("SELECT id,name,price,stock FROM products WHERE id=? AND active=1",(pid,)).fetchone()
        if not p: raise HTTPException(404,"Producto no encontrado")
        return obj(p)

    @app.post("/products",status_code=201)
    def add_product(p:Product,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key,x_user_id,x_user_role,True)
        pid=str(uuid4())
        with conn() as c: c.execute("INSERT INTO products VALUES(?,?,?,?,?)",(pid,p.name,p.price,p.stock,int(p.active)))
        return {"id":pid,**p.model_dump()}

    @app.put("/products/{pid}")
    def put_product(pid:str,p:Product,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key,x_user_id,x_user_role,True)
        with conn() as c:
            result=c.execute("UPDATE products SET name=?,price=?,stock=?,active=? WHERE id=?",(p.name,p.price,p.stock,int(p.active),pid))
            if not result.rowcount: raise HTTPException(404,"Producto no encontrado")
        return {"id":pid,**p.model_dump()}

    @app.delete("/products/{pid}")
    def delete_product(pid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key,x_user_id,x_user_role,True)
        with conn() as c:
            r=c.execute("UPDATE products SET active=0 WHERE id=?",(pid,))
            if not r.rowcount: raise HTTPException(404,"Producto no encontrado")
        return {"ok":True}

    @app.post("/reserve")
    def reserve(p:Reserve,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c:
            exists=c.execute("SELECT * FROM reservations WHERE order_id=?",(p.order_id,)).fetchone()
            if exists: raise HTTPException(409,"Reserva duplicada")
            r=c.execute("UPDATE products SET stock=stock-? WHERE id=? AND active=1 AND stock>=?",(p.quantity,p.product_id,p.quantity))
            if not r.rowcount: raise HTTPException(409,"Stock insuficiente")
            c.execute("INSERT INTO reservations VALUES(?,?,?)",(p.order_id,p.product_id,p.quantity))
        return {"reserved":True}

    @app.post("/release/{order_id}")
    def release(order_id:str,x_internal_key:str=Header(default="")):
        verify(x_internal_key)
        with conn() as c:
            r=c.execute("SELECT * FROM reservations WHERE order_id=?",(order_id,)).fetchone()
            if r:
                c.execute("UPDATE products SET stock=stock+? WHERE id=?",(r["quantity"],r["product_id"]))
                c.execute("DELETE FROM reservations WHERE order_id=?",(order_id,))
        return {"released":bool(r)}

if SERVICE=="orders":
    @app.post("/orders",status_code=201)
    async def create_order(p:Order,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        if not x_user_id: raise HTTPException(401,"Sesión requerida")
        product=await request_internal("inventory","GET",f"/products/{p.product_id}")
        oid=str(uuid4())
        await request_internal("inventory","POST","/reserve",{"order_id":oid,"product_id":p.product_id,"quantity":p.quantity})
        try:
            with conn() as c: c.execute("INSERT INTO orders VALUES(?,?,?,?,?,?)",(oid,x_user_id,p.product_id,p.quantity,product["price"]*p.quantity,"pending"))
        except Exception:
            await request_internal("inventory","POST",f"/release/{oid}")
            raise
        return {"id":oid,"status":"pending","total":product["price"]*p.quantity}

    @app.get("/orders")
    def my_orders(x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        if not x_user_id: raise HTTPException(401,"Sesión requerida")
        with conn() as c:
            if x_user_role=="admin": rows=c.execute("SELECT * FROM orders ORDER BY rowid DESC LIMIT 100").fetchall()
            else: rows=c.execute("SELECT * FROM orders WHERE user_id=? ORDER BY rowid DESC LIMIT 100",(x_user_id,)).fetchall()
        return [obj(r) for r in rows]

    @app.get("/orders/{oid}")
    def get_order(oid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        if not x_user_id: raise HTTPException(401,"Sesión requerida")
        with conn() as c: r=c.execute("SELECT * FROM orders WHERE id=?",(oid,)).fetchone()
        if not r: raise HTTPException(404,"Pedido no encontrado")
        if r["user_id"]!=x_user_id and x_user_role!="admin": raise HTTPException(403,"Pedido ajeno")
        return obj(r)

    @app.post("/orders/{oid}/cancel")
    async def cancel(oid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        current=get_order(oid,x_internal_key,x_user_id,x_user_role)
        if current["status"]!="pending": raise HTTPException(409,"No se puede anular")
        # Liberar primero la reserva. Si inventory falla, el pedido sigue pendiente.
        # La operación release es idempotente, de modo que un reintento es seguro.
        await request_internal("inventory","POST",f"/release/{oid}")
        with conn() as c:
            changed=c.execute("UPDATE orders SET status='cancelled' WHERE id=? AND status='pending'",(oid,))
            if not changed.rowcount:
                raise HTTPException(409,"Estado modificado por otra solicitud")
        return {"status":"cancelled"}

    @app.post("/orders/{oid}/paid")
    def mark_paid(oid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key,x_user_id,x_user_role,True)
        with conn() as c:
            existing=c.execute("SELECT status FROM orders WHERE id=?",(oid,)).fetchone()
            if not existing: raise HTTPException(404,"Pedido no encontrado")
            if existing["status"]=="paid": return {"status":"paid","idempotent":True}
            if existing["status"]!="pending": raise HTTPException(409,"Estado inválido")
            r=c.execute("UPDATE orders SET status='paid' WHERE id=? AND status='pending'",(oid,))
            if not r.rowcount: raise HTTPException(409,"Cambio concurrente")
        return {"status":"paid","idempotent":False}

if SERVICE=="payments":
    @app.post("/payments/{oid}")
    async def initiate(oid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key)
        if not x_user_id: raise HTTPException(401,"Sesión requerida")
        order=await request_internal("orders","GET",f"/orders/{oid}",user=x_user_id,role=x_user_role)
        if order["status"]!="pending": raise HTTPException(409,"Pedido no pagable")
        with conn() as c:
            existing=c.execute("SELECT * FROM payments WHERE order_id=?",(oid,)).fetchone()
            if existing: return obj(existing)
            pay_id=str(uuid4())
            c.execute("INSERT INTO payments VALUES(?,?,?,?)",(pay_id,oid,order["total"],"pending"))
        return {"id":pay_id,"order_id":oid,"amount":order["total"],"status":"pending","mode":"sandbox"}

    @app.post("/sandbox/confirm/{oid}")
    async def confirm(oid:str,x_internal_key:str=Header(default=""),x_user_id:str=Header(default=""),x_user_role:str=Header(default="")):
        verify(x_internal_key,x_user_id,x_user_role,True)
        with conn() as c:
            p=c.execute("SELECT * FROM payments WHERE order_id=?",(oid,)).fetchone()
            if not p: raise HTTPException(404,"Pago no encontrado")
            if p["status"]=="paid": return {"status":"paid","idempotent":True}
        await request_internal("orders","POST",f"/orders/{oid}/paid",user=x_user_id,role=x_user_role)
        with conn() as c: c.execute("UPDATE payments SET status='paid' WHERE order_id=?",(oid,))
        return {"status":"paid","idempotent":False}
