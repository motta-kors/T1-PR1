# Gelato Artesanal — informe técnico, semana 14

## Alcance
Heladería artesanal: catálogo, clientes, stock, pedidos, pagos sandbox e historial. Número oficial del caso e integrantes pendientes de confirmación. No se realizan cobros reales.

## Arquitectura y módulos
- [Guía y módulos 1–10](../README.md)
- [Contratos y trazabilidad](contracts-and-traceability.md)
- [Seguridad, roles y rutas](security-and-routes.md)
- [ADR de REST y alternativas](adr-001-rest.md)
- [Diagramas editables](../diagrams/)
- [Esquema GraphQL](schema.graphql)
- [Resultados históricos de CI](ci-results.md)

## Cambios de semana 14
Identidad Gelato Artesanal, cantidad seleccionable por producto en la tienda de demostración, rechazo de campos adicionales en pedidos y productos, esquema GraphQL externo utilizado en ejecución, workflow con captura de CPU y memoria.

## Validación
Ejecutar el workflow de la rama semana-14. No trasladar resultados de semana-11 como si fueran de esta versión. Los ejemplos de catálogo son ficticios.

## Limitaciones y evolución
El pedido aún contiene un tipo de producto por operación. Carrito de múltiples sabores, categorías, historial de transiciones, analítica, separación de módulos Python y pagos reales no forman parte de los cambios actuales. SQLite y sesiones opacas se conservan. Evaluar estos cambios según la rúbrica y mediante pruebas de regresión.
