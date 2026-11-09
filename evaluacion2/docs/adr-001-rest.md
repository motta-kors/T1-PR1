# ADR-001: REST interno frente a gRPC y analítica separada
Estado: provisional, pendiente de evidencia de carga (2026-11-08).

## Contexto
Sistema académico de catálogo, clientes, inventario, pedidos y pago ficticio.
No se han documentado requisitos de streaming, análisis masivo ni concurrencia intensiva.
La documentación del profesor indica que el backend debe representar eventos de la web; la integración visual completa no se exige en esta entrega.

## Opciones evaluadas
1. REST HTTP entre servicios privados con contratos JSON.
2. gRPC tipado para streaming o comunicación de muy alta demanda.
3. Servicio de analítica especializado, alimentado de eventos o réplicas.

## Decisión
REST interno como opción inicial; GraphQL privado agrega orders+inventory.
No se implementa gRPC ni analítica separada mientras no se demuestre su necesidad mediante las reglas del caso, volumen y latencia.

## Validación necesaria
Ejecutar `python tests/load_test.py --requests 200 --concurrency 10` con el sistema levantado.
Registrar versión del entorno, objetivos p95, throughput, porcentaje de errores, CPU y RAM (`docker stats --no-stream`).
Repetir con distintas concurrencias y pruebas de fallo. No afirmar que REST es superior sin datos medidos.

## Consecuencias
- Menor complejidad operativa.
- El modelo de carga real podría justificar rediseño.
- No evita que se requieran reintentos, idempotencia y seguridad entre servicios.
