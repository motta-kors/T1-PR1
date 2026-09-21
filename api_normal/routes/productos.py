from fastapi import APIRouter, HTTPException

router = APIRouter()

PRODUCTOS = [
    {"id": 1, "nombre": "Chocolate Belga", "precio": 4500},
    {"id": 2, "nombre": "Frutilla Natural", "precio": 4500},
    {"id": 3, "nombre": "Pistacho", "precio": 5000},
    {"id": 4, "nombre": "Limón", "precio": 4200},
    {"id": 5, "nombre": "Cookies & Cream", "precio": 4700},
    {"id": 6, "nombre": "Menta Chocolate", "precio": 4700},
]

@router.get("")
def listar_productos():
    return {"data": PRODUCTOS}

@router.get("/{producto_id}")
def obtener_producto(producto_id: int):
    producto = next((p for p in PRODUCTOS if p["id"] == producto_id), None)
    if producto is None:
        raise HTTPException(status_code=404, detail="Producto no encontrado")
    return producto
