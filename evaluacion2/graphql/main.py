import os
import httpx
from fastapi import FastAPI, Request, HTTPException
from graphql import build_schema, graphql, parse, OperationType

KEY=os.environ["INTERNAL_SERVICE_KEY"]
app=FastAPI(title="GraphQL Gateway privado",docs_url=None,redoc_url=None)
schema=build_schema("""
type Product { id: ID!, name: String!, price: Int!, stock: Int! }
type OrderDetail { id: ID!, quantity: Int!, total: Int!, status: String!, product: Product }
type Query { myOrders: [OrderDetail!]! }
""")

async def internal(service,path,uid,role):
    try:
        async with httpx.AsyncClient(timeout=5) as client:
            r=await client.get(f"http://{service}:8000{path}",headers={"x-internal-key":KEY,"x-user-id":uid,"x-user-role":role})
            r.raise_for_status()
            return r.json()
    except (httpx.RequestError,httpx.HTTPStatusError):
        raise RuntimeError("Subsistema temporalmente no disponible")

async def resolve_orders(_root,info):
    uid=info.context["uid"]
    role=info.context["role"]
    orders=await internal("orders","/orders",uid,role)
    # Batching: se consulta una vez el catálogo, no una vez por ítem.
    products=await internal("inventory","/products",uid,role)
    lookup={p["id"]:p for p in products}
    return [{**o,"product":lookup.get(o["product_id"])} for o in orders[:50]]
schema.get_type("Query").fields["myOrders"].resolve=resolve_orders

def check(node,depth=0):
    if depth>5: raise HTTPException(400,"Profundidad GraphQL excedida")
    n=1
    for sel in getattr(getattr(node,"selection_set",None),"selections",[]) or []:
        if getattr(getattr(sel,"name",None),"value","").startswith("__"):
            raise HTTPException(400,"Introspección deshabilitada")
        n+=check(sel,depth+1)
    if n>40: raise HTTPException(400,"Consulta demasiado compleja")
    return n

@app.get("/health")
def health(): return {"status":"ok","service":"graphql"}

@app.post("/graphql")
async def endpoint(request:Request):
    if request.headers.get("x-internal-key")!=KEY: raise HTTPException(403,"Acceso privado")
    uid=request.headers.get("x-user-id")
    role=request.headers.get("x-user-role")
    if not uid or role not in ("client","admin"): raise HTTPException(401,"Identidad requerida")
    body=await request.json()
    query=body.get("query","")
    if not isinstance(query,str) or len(query)>1800: raise HTTPException(400,"Consulta inválida")
    try: ast=parse(query)
    except Exception: raise HTTPException(400,"Sintaxis GraphQL inválida")
    if len(ast.definitions)!=1: raise HTTPException(400,"Solo una operación por solicitud")
    operation=ast.definitions[0]
    if getattr(operation,"operation",None)!=OperationType.QUERY: raise HTTPException(403,"Solo consultas")
    check(operation)
    result=await graphql(schema,query,context_value={"uid":uid,"role":role})
    output={"data":result.data}
    if result.errors: output["errors"]=[{"message":"Error al consultar subsistemas"} for _ in result.errors]
    return output
