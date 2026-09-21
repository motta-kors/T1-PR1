from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field
from pymongo import MongoClient, ASCENDING
from pymongo.errors import DuplicateKeyError

app = FastAPI(
    title="T1-PR1 API",
    description="API CRUD de productos de Gelato Artesanal con FastAPI y MongoDB",
    version="2.1.0",
)

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=False,
    allow_methods=["*"],
    allow_headers=["*"],
)

MONGO_URL = "mongodb://127.0.0.1:27017"
client = MongoClient(MONGO_URL)
db = client["T1_PR1"]
coleccion_productos = db["productos"]
coleccion_productos.create_index([("id", ASCENDING)], unique=True)


class Producto(BaseModel):
    id: int = Field(gt=0)
    nombre: str = Field(min_length=1)
    precio: int = Field(gt=0)


PRODUCTOS_INICIALES = [
    {"id": 1, "nombre": "Cono Doble Barquillo", "precio": 4500},
    {"id": 2, "nombre": "Pote Familiar 1000ml", "precio": 9900},
    {"id": 3, "nombre": "Pote Mediano 500ml", "precio": 5900},
    {
        "id": 4,
        "nombre": "Pote Especial Pistacho y Frutos del Bosque",
        "precio": 6500,
    },
]


def limpiar_producto(documento):
    if documento is None:
        return None

    documento.pop("_id", None)
    return documento


def sembrar_productos():
    productos_anteriores = [
        {"id": 1, "nombre": "Teclado", "precio": 4590},
        {"id": 2, "nombre": "Mouse", "precio": 6000},
    ]

    for producto in productos_anteriores:
        coleccion_productos.delete_one(producto)

    for producto in PRODUCTOS_INICIALES:
        coleccion_productos.update_one(
            {"id": producto["id"]},
            {"$set": producto},
            upsert=True,
        )


sembrar_productos()


@app.get("/")
def inicio():
    return {
        "mensaje": "API de Gelato Artesanal funcionando correctamente",
        "base_datos": "MongoDB",
    }


@app.get("/productos")
def obtener_productos():
    productos = [
        limpiar_producto(producto)
        for producto in coleccion_productos.find().sort("id", ASCENDING)
    ]

    return {
        "status": 200,
        "message": "Productos obtenidos correctamente",
        "data": productos,
    }


@app.get("/productos/{producto_id}")
def obtener_producto(producto_id: int):
    producto = limpiar_producto(
        coleccion_productos.find_one({"id": producto_id})
    )

    if producto is None:
        raise HTTPException(status_code=404, detail="Producto no encontrado")

    return producto


@app.post("/productos", status_code=201)
def crear_producto(producto: Producto):
    datos = producto.model_dump()

    try:
        coleccion_productos.insert_one(datos.copy())
    except DuplicateKeyError:
        raise HTTPException(
            status_code=409,
            detail="Ya existe un producto con ese ID",
        )

    return {
        "status": 201,
        "message": "Producto creado correctamente",
        "data": datos,
    }


@app.put("/productos/{producto_id}")
def actualizar_producto(producto_id: int, producto: Producto):
    if producto.id != producto_id:
        raise HTTPException(
            status_code=400,
            detail="El ID de la URL debe coincidir con el ID del producto",
        )

    resultado = coleccion_productos.replace_one(
        {"id": producto_id},
        producto.model_dump(),
    )

    if resultado.matched_count == 0:
        raise HTTPException(status_code=404, detail="Producto no encontrado")

    return {
        "status": 200,
        "message": "Producto actualizado correctamente",
        "data": producto.model_dump(),
    }


@app.delete("/productos/{producto_id}")
def eliminar_producto(producto_id: int):
    resultado = coleccion_productos.delete_one({"id": producto_id})

    if resultado.deleted_count == 0:
        raise HTTPException(status_code=404, detail="Producto no encontrado")

    return {
        "status": 200,
        "message": "Producto eliminado correctamente",
    }
