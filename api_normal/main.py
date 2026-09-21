from fastapi import FastAPI
from routes.productos import router as productos_router

app = FastAPI(title="API Normal - Gelato Artesanal")

@app.get("/")
def inicio():
    return {"servicio": "api-normal", "estado": "ok"}

app.include_router(productos_router, prefix="/productos", tags=["productos"])
