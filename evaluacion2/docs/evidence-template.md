# Evidencias ejecutadas — completar con resultados verificables

> Este archivo es una plantilla. **No inventar capturas, tiempos ni resultados**.
> Fecha y hora de ejecución: ________
> Equipo: ________ Sistema operativo: ________
> Versión Docker: ________ Commit SHA: ________

| ID | Escenario | Comando o prueba | Resultado esperado | Resultado real | Evidencia |
|---|---|---|---|---|---|
| T01 | Catálogo anónimo | test_catalogo_anonimo | 200 JSON | Pendiente | |
| T02 | Pedidos sin sesión | test_pedidos_sin_token | 401 | Pendiente | |
| T03 | Ruta interna bloqueada | test_gateway_no_expone_rutas_internas | 404 | Pendiente | |
| T04 | Registro y acceso | test_roles_y_graphql | 201/200 | Pendiente | |
| T05 | Cliente intenta crear producto | test_roles_y_graphql | 403 | Pendiente | |
| T06 | Pedido ajeno | test_ajeno_admin_y_stock | 403 | Pendiente | |
| T07 | Sobreventa | test_ajeno_admin_y_stock | 409 | Pendiente | |
| T08 | Liberar stock | test_ajeno_admin_y_stock | Stock recuperado | Pendiente | |
| T09 | Pagos duplicados | test_sandbox_payment_idempotence | 200 idempotente | Pendiente | |
| T10 | GraphQL y protección | test_graphql_limits | Limita introspección y costos | Pendiente | |
| T11 | Prueba de carga | tests/load_test.py | Objetivo declarado | Pendiente | |

### Capturas mínimas
- docker compose ps y health checks
- salida completa de pytest -v
- consulta GraphQL y respuesta real
- demostración del rol cliente (403) y administrador (201)
- carga con latencia p95 / throughput / errores
- docker stats --no-stream para CPU y memoria

### Observaciones y fallos
Registrar errores observados, correcciones y re-ejecución.
