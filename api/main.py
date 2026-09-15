from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

app = FastAPI(
    title="T1-PR1 API",
    description="API de productos para el proyecto web T1-PR1",
    version="1.0.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


class Producto(BaseModel):
    id: int
    nombre: str
    precio: int


productos = [
    {"id": 1, "nombre": "Teclado", "precio": 4590},
    {"id": 2, "nombre": "Mouse", "precio": 6000},
]


@app.get("/")
def inicio():
    return {"mensaje": "API funcionando correctamente"}


@app.get("/productos")
def obtener_productos():
    return {
        "status": 200,
        "message": "Productos obtenidos correctamente",
        "data": productos,
    }


@app.get("/productos/{producto_id}")
def obtener_producto(producto_id: int):
    for producto in productos:
        if producto["id"] == producto_id:
            return producto

    return {
        "status": 404,
        "message": "Producto no encontrado",
    }


@app.post("/productos", status_code=201)
def crear_producto(producto: Producto):
    productos.append(producto.model_dump())
    return {
        "status": 201,
        "message": "Producto creado correctamente",
        "data": producto,
    }
