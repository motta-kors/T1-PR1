# Módulo 1 y 10 — contratos, trazabilidad y pruebas

## Contexto
Frontend conservado: `index.php` (inicio), `productos.php` (catálogo), `contactos.php` (contacto), `empresa.php`, `servicios.php`.
La página `tienda-segura.php` es una extensión opcional. Como indicó el profesor, las pantallas representan eventos; no se exige integración completa en la entrega 2.
**Pendiente:** identificar número y nombre del caso oficial entre los 40 del curso. No atribuir requisitos inventados al caso.

Los DTO distinguen datos públicos (catálogo) y restringidos (perfil, pedidos, tokens). Todas las entradas JSON se validan por Pydantic y verificaciones de negocio. GET no envía cuerpo. Los precios y estados se calculan en servicios privados.

| ID | Requisito funcional asumido | Pantalla / evento | Método y ruta externa | Entrada / validación | Salida y errores | Sistema | Prueba |
|---|---|---|---|---|---|---|---|
| S01 | R01 ver productos | P02 productos/cargar | GET /api/v1/products | sin cuerpo | 200 array, 503 | inventory | T01 |
| S02 | R01 ver detalle | P02 detalle | GET /api/v1/products/{id} | UUID | 200 producto, 404 | inventory | T07 |
| S03 | R02 alta administrativa | P04 administración/crear | POST /api/v1/products | name 1..120, price>=0, stock>=0 | 201, 401, 403, 422 | inventory | T05 |
| S04 | R02 edición | P04 administración/editar | PUT /api/v1/products/{id} | UUID y producto completo | 200, 403, 404 | inventory | T05 |
| S05 | R02 desactivar | P04 administración/baja | DELETE /api/v1/products/{id} | UUID | 200, 403, 404 | inventory | T05 |
| S06 | R03 registro | P03 registro/enviar | POST /api/v1/auth/register | email, name, password >=10 | 201, 409, 422 | auth, clients | T04 |
| S07 | R03 login | P03 acceso/enviar | POST /api/v1/auth/login | email, password | 200 token, 401 | auth | T04 |
| S08 | R03 logout | P03 salir | POST /api/v1/auth/logout | Bearer | 200, 401 | auth | T04 |
| S09 | R04 perfil | P03 ver cuenta | GET /api/v1/me | Bearer | 200 propios, 401, 404 | clients | T04 |
| S10 | R05 crear pedido | P02 comprar | POST /api/v1/orders | product_id UUID, quantity 1..50 | 201 id/total, 409 stock | orders, inventory | T06 |
| S11 | R05 listar pedidos | P05 historial/listar | GET /api/v1/orders | Bearer | 200 propios, 401 | orders | T02 |
| S12 | R05 detalle de pedido | P05 historial/detalle | GET /api/v1/orders/{id} | UUID, Bearer | 200, 403 ajeno, 404 | orders | T06 |
| S13 | R05 anulación | P05 historial/anular | POST /api/v1/orders/{id}/cancel | UUID, Bearer | 200, 409 | orders, inventory | T08 |
| S14 | R06 iniciar pago | P05 pagar | POST /api/v1/payments/{id} | Bearer propietario | 200 sandbox, 403, 409 | payments | T09 |
| S15 | R06 confirmar pago de prueba | P04 admin/confirmar | POST /api/v1/sandbox/confirm/{id} | Bearer admin | 200, 403, 404 | payments, orders | T09 |
| S16 | R07 resumen de pedidos | P05 historial/agregar | POST /api/v1/graphql | GraphQL Query autenticada | 200 data, 400/403/401 | graphql, orders, inventory | T10 |

P01 = inicio; P02 = productos; P03 = cuenta; P04 = administración; P05 = pedidos.
R01–R07 son requisitos **inferidos para la demostración**, no transcripción del caso entregado al curso.

### Ejemplos de contratos JSON ficticios
Registro: `{"email":"alguien@example.test","name":"Cliente de prueba","password":"UnaClaveFicticia123!"}`.
Login: `{"email":"alguien@example.test","password":"UnaClaveFicticia123!"}` -> `{"access_token":"[TOKEN_OPACO]","token_type":"bearer","expires_in":1800}`.
Producto: `{"name":"Bloque decorativo","price":5000,"stock":10,"active":true}` -> `{"id":"[UUID]","name":"Bloque decorativo","price":5000,"stock":10,"active":true}`.
Pedido: `{"product_id":"[UUID]","quantity":2}` -> `{"id":"[UUID]","status":"pending","total":10000}`.
Pago: `POST /payments/[UUID]` -> `{"id":"[UUID]","order_id":"[UUID]","amount":10000,"status":"pending","mode":"sandbox"}`.
Error: `{"detail":"Stock insuficiente"}` con código 409.

### Reglas del servidor
- Cantidad positiva y limitada; stock decrece por reserva atómica.
- El precio de pedido se obtiene de inventory; nunca se confía en el precio enviado desde el navegador.
- Los clientes solo pueden ver sus pedidos.
- La eliminación de producto se implementa como desactivación para no perder el historial.
- La confirmación de pago solo está permitida a admin en el simulador local.
- `GraphQL myOrders` combina pedidos y atributos públicos del catálogo.

### Dependencias y errores
- Auth crea usuario y perfil. Si el perfil falla, elimina el usuario recién creado.
- Orders solicita reserva antes de confirmar el pedido. Si insertar el pedido falla, intenta liberar stock.
- Cancelación utiliza estado transitorio `cancelling`, libera reserva y confirma `cancelled`.
- **Limitación documentada:** una caída completa entre estas etapas puede exigir reconciliación manual. No es una transacción distribuida.
- Pagos de prueba usan un identificador único por pedido y reintentos idempotentes.
- Al desplegar pagos reales se requiere webhook firmado, reconciliación y proveedor con contratos oficiales.

### Matriz requisito ↔ prueba
R01: T01 y T07; R02: T05; R03: T04; R04: T04; R05: T02, T06, T08; R06: T09; R07: T10.
Los resultados reales y la evidencia se registran en `docs/evidence-template.md`.
