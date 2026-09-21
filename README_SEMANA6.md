# Semana 6

Esta rama separa claramente las dos partes pedidas en clase.

## 1. Frontend
El sitio de **Gelato Artesanal** funciona sin backend:
- páginas PHP usadas como vistas;
- diseño con Bootstrap + Estilo.css;
- interacción mediante JavaScript;
- navegación y selección de productos usando parámetros de URL.

Ejemplo:
`productos.php?sabor=Pistacho&precio=5000`

## 2. API normal + routing
La API normal está en `api_normal/`.

Ejecutar desde la raíz:

```bash
uvicorn api_normal.main:app --reload --port 8001
```

Documentación:
`http://127.0.0.1:8001/docs`

Las rutas de productos están separadas con `APIRouter` en:
`api_normal/routes/productos.py`

## 3. API Gateway
El gateway está en `api_gateway/` y redirige las consultas hacia la API normal.

Ejecutar en otra terminal:

```bash
uvicorn api_gateway.main:app --reload --port 8000
```

Documentación:
`http://127.0.0.1:8000/docs`

Rutas principales:
- `GET /api/productos`
- `GET /api/productos/{producto_id}`

## Instalación

```bash
pip install -r requirements.txt
```

Para probar correctamente el gateway, mantener ambas APIs ejecutándose al mismo tiempo.
