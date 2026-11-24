# T1-PR1 — Gelato Artesanal — Semana 14

Este repositorio conserva el sitio PHP/Bootstrap original y agrega una implementación académica del backend seguro solicitada en la Evaluación de la Unidad 2.

## Contenido original conservado
- `index.php`, `productos.php`, `empresa.php`, `servicios.php`, `contactos.php`
- `index.html`, scripts y estilos originales, además de ejercicios PHP y JavaScript
- `auth-service/server.js` (ejemplo legado corregido para no usar secretos fijos)
- `.idea/Semana 5` y demás materiales previos

## Trabajo de Evaluación 2
- `evaluacion2/services/main.py`: auth, clients, inventory, orders, payments
- `evaluacion2/gateway/main.py`: API Gateway con rutas y roles
- `evaluacion2/graphql/main.py`: consulta agregada myOrders (orders + inventory)
- `evaluacion2/docker-compose.yml`: servicios aislados y persistencia separada
- `evaluacion2/tests/`: pruebas automatizadas y carga
- `evaluacion2/diagrams/`: UML y diagramas editables Mermaid
- `evaluacion2/docs/`: contratos, seguridad, ADR, matrices y plantilla de evidencias
- `tienda-segura.php`, `tienda-segura.js`: demostración opcional; no reemplaza páginas anteriores.

**Ver guía de arranque:** [evaluacion2/README.md](evaluacion2/README.md).

**Aclaración docente del 08-11-2026:** en esta evaluación la integración visual completa del frontend no es exigencia obligatoria; sí deben representarse los eventos y datos de frontend mediante servicios de backend, roles y verbos significativos.

**Validación:** El repositorio contiene pruebas, pero las evidencias deben producirse mediante ejecuciones exitosas. El número/nombre del caso de los 40 del curso debe ser confirmado con el equipo; el contexto del proyecto es Gelato Artesanal.

## Semana 14
Catálogo de helados artesanales, gestión de existencias, clientes, pedidos y pagos de prueba. Consulte el [informe técnico](evaluacion2/docs/informe-gelato.md) y el [esquema GraphQL](evaluacion2/docs/schema.graphql). Los resultados históricos están en [ci-results](evaluacion2/docs/ci-results.md); la nueva versión requiere una ejecución propia.
