from fastapi import FastAPI, HTTPException
import httpx

app = FastAPI(title="API Gateway - Gelato Artesanal")
API_NORMAL_URL = "http://127.0.0.1:8001"

@app.get("/")
def inicio():
    return {"servicio": "api-gateway", "estado": "ok"}

@app.get("/api/productos")
async def gateway_productos():
    try:
        async with httpx.AsyncClient() as client:
            respuesta = await client.get(f"{API_NORMAL_URL}/productos")
        respuesta.raise_for_status()
        return respuesta.json()
    except httpx.HTTPError as error:
        raise HTTPException(status_code=502, detail=f"Error comunicando con API normal: {error}")

@app.get("/api/productos/{producto_id}")
async def gateway_producto(producto_id: int):
    try:
        async with httpx.AsyncClient() as client:
            respuesta = await client.get(f"{API_NORMAL_URL}/productos/{producto_id}")
        if respuesta.status_code == 404:
            raise HTTPException(status_code=404, detail="Producto no encontrado")
        respuesta.raise_for_status()
        return respuesta.json()
    except HTTPException:
        raise
    except httpx.HTTPError as error:
        raise HTTPException(status_code=502, detail=f"Error comunicando con API normal: {error}")
