# Evidencia verificable — GitHub Actions

**Origen:** [Ejecución 42548008767](https://github.com/motta-kors/T1-PR1/actions/runs/42548008767)

- Commit: `e4844114fd215f390754d40b9ceff96a44775cc2`
- Fecha del log: 2026-11-09 01:55 UTC (2026-11-08 21:55 Chile)
- Estado del workflow: success
- Build y arranque Docker Compose: success
- Provisión de administrador temporal: success
- Tests funcionales y de seguridad: **8 passed in 3.32s**
- Carga REST: **100 solicitudes**, concurrencia **5**, duración **2.07 s**
- Throughput: **48.31 req/s**
- Latencia p50: **101.42 ms**
- Latencia p95: **132.86 ms**
- Errores: **0 (0.00%)**
- Cierre de contenedores: success

## Pruebas ejecutadas
| Prueba | Resultado |
|---|---|
| test_ajeno_admin_y_stock | PASSED |
| test_sandbox_payment_idempotence | PASSED |
| test_graphql_limits | PASSED |
| test_validation_and_routing | PASSED |
| test_catalogo_anonimo | PASSED |
| test_pedidos_sin_token | PASSED |
| test_gateway_no_expone_rutas_internas | PASSED |
| test_roles_y_graphql | PASSED |

## Interpretación y límites
Estas cifras son **mediciones del runner de GitHub Actions**, no del equipo del alumno ni de un ambiente de producción. No demuestran desempeño general a mayor concurrencia. El benchmark no incluye en su salida CPU y memoria; estas métricas deben capturarse con `docker stats --no-stream` y agregarse al informe.

La ejecución validó el backend y los servicios a ese SHA. Las modificaciones posteriores de archivos web auxiliares no estaban incluidas en ese commit; revisar el workflow más reciente para informar validación de la rama completa.

**No reemplazar estos datos por números inventados.**
