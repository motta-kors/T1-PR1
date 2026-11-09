import os, secrets
from uuid import UUID
import httpx
from fastapi import FastAPI, HTTPException, Request
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse, Response

KEY=os.environ["INTERNAL_SERVICE_KEY"]
HOSTS={x:f"http://{x}:8000" for x in ("auth","inventory","orders","clients","payments","graphql")}
app=FastAPI(title="Minecraft Web - API Gateway",version="2.0")
app.add_middleware(CORSMiddleware,allow_origins=[x.strip() for x in os.getenv("FRONTEND_ORIGIN","http://localhost:8081").split(",")],allow_methods=["GET","POST","PUT","DELETE"],allow_headers=["Authorization","Content-Type"])

# Lista cerrada: el navegador no elige destinos internos, políticas ni cabeceras de identidad.
ROUTES={
    ("GET","/api/v1/products"):("inventory","/products","public"),
    ("GET","/api/v1/me"):("clients","/me","client"),
    ("GET","/api/v1/orders"):("orders","/orders","client"),
    ("POST","/api/v1/orders"):("orders","/orders","client"),
    ("POST","/api/v1/auth/register"):("auth","/register","public"),
    ("POST","/api/v1/auth/login"):("auth","/login","public"),
    ("POST","/api/v1/auth/logout"):("auth","/logout","client"),
    ("POST","/api/v1/products"):("inventory","/products","admin"),
    ("POST","/api/v1/graphql"):("graphql","/graphql","client"),
}
async def upstream(service,method,path,body=None,identity=None,token=None):
    headers={"x-internal-key":KEY}
    if identity:
        headers.update({"x-user-id":identity["user_id"],"x-user-role":identity["role"]})
    if token: body={"token":token}
    try:
        async with httpx.AsyncClient(timeout=8) as client:
            r=await client.request(method,HOSTS[service]+path,json=body,headers=headers)
    except httpx.RequestError:
        raise HTTPException(503,"Servicio temporalmente no disponible")
    if r.status_code==204: return Response(status_code=204)
    try: payload=r.json()
    except ValueError: raise HTTPException(502,"Respuesta inválida del servicio")
    return JSONResponse(payload,status_code=r.status_code)

async def who(request):
    authorization=request.headers.get("authorization","")
    if not authorization.startswith("Bearer "): raise HTTPException(401,"Token requerido")
    token=authorization[7:].strip()
    if not token: raise HTTPException(401,"Token requerido")
    r=await upstream("auth","POST","/introspect",{"token":token})
    data=__import__("json").loads(r.body)
    if not data.get("active"): raise HTTPException(401,"Sesión inválida o expirada")
    return data,token

@app.get("/health")
def health(): return {"status":"ok","service":"gateway"}

@app.api_route("/api/v1/{remaining:path}",methods=["GET","POST","PUT","DELETE"])
async def gateway(remaining:str,request:Request):
    path="/api/v1/"+remaining
    match=ROUTES.get((request.method,path))
    # Se admiten IDs solo con caracteres de UUID y subrutas concretas.
    pieces=remaining.split("/")
    def valid_id(raw):
        try: return str(UUID(raw))==raw.lower()
        except (ValueError, AttributeError): return False
    if not match and len(pieces)==2 and pieces[0]=="products" and valid_id(pieces[1]):
        if request.method=="GET": match=("inventory","/products/"+pieces[1],"public")
        if request.method in ("PUT","DELETE"): match=("inventory","/products/"+pieces[1],"admin")
    if not match and len(pieces)==2 and pieces[0]=="orders" and valid_id(pieces[1]) and request.method=="GET":
        match=("orders","/orders/"+pieces[1],"client")
    if not match and len(pieces)==3 and pieces[0]=="orders" and valid_id(pieces[1]) and pieces[2]=="cancel" and request.method=="POST":
        match=("orders","/orders/"+pieces[1]+"/cancel","client")
    if not match and len(pieces)==2 and pieces[0]=="payments" and valid_id(pieces[1]) and request.method=="POST":
        match=("payments","/payments/"+pieces[1],"client")
    if not match and len(pieces)==3 and pieces[0]=="sandbox" and pieces[1]=="confirm" and valid_id(pieces[2]) and request.method=="POST":
        match=("payments","/sandbox/confirm/"+pieces[2],"admin")
    if not match: raise HTTPException(404,"Ruta no permitida")
    service,target,policy=match
    identity=None;token=None
    if policy!="public":
        identity,token=await who(request)
        if policy=="admin" and identity["role"]!="admin": raise HTTPException(403,"No autorizado")
    try: body=await request.json() if request.method in ("POST","PUT") else None
    except ValueError: raise HTTPException(400,"JSON inválido")
    if service=="auth" and target=="/logout":
        return await upstream(service,request.method,target,identity=identity,token=token)
    return await upstream(service,request.method,target,body,identity)
