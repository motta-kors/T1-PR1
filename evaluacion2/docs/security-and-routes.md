# Módulos 4, 6 y 7 — actores, rutas e identidades

## Clasificación de datos
| Dato / credencial | Uso | Clasificación | Dueño | Acceso | Protección | Retención |
|---|---|---|---|---|---|---|
| ID y nombre de producto | catálogo | público | inventory | anónimo | filtro de campos | mientras producto exista |
| Precio y stock público | catálogo | público | inventory | anónimo | validación servidor | actualizado |
| Email y nombre de cuenta | identidad y contacto | personal restringido | auth / clients | titular | red privada, control titular | hasta supresión programada |
| Hash/salt de contraseña | autenticación | credencial derivada | auth | servicio auth | scrypt + sal | hasta eliminación de cuenta |
| Token opaco | sesión | credencial secreta | auth | titular | token hash persistido; expira en 30 min | eliminación al logout y expiración |
| Historial de pedidos | seguimiento | personal restringido | orders | propietario o admin | verificación en backend | plazo legal a definir |
| INTERNAL_SERVICE_KEY | autenticación entre servicios | secreto técnico | operador | contenedores autorizados | variable local no versionada | rotar ante incidente |
| Estado de pago sandbox | pruebas | transaccional restringido | payments | propietario o admin | nunca confiar en navegador | según política de pruebas |

**Decisión explícita sobre secretos de clientes:** no se custodian claves privadas de pagos ni tokens de proveedores de clientes. Sí se administran contraseñas (solo sus hashes) y sesiones opacas. No usar tarjetas reales.

## Matriz de autorización simplificada
| Rol | GET productos | POST/PUT/DELETE producto | GET perfil | POST pedido | GET pedido propio | GET pedido ajeno | POST confirmación sandbox |
|---|---|---|---|---|---|---|---|
| Visitante | Permitido | Denegado | Denegado | Denegado | Denegado | Denegado | Denegado |
| Cliente | Permitido | Denegado | Propio | Permitido | Permitido | Denegado 403 | Denegado |
| Admin | Permitido | Permitido | Propio | Permitido | Permitido | Permitido | Permitido |
| Docente, evaluador | Información de prueba | Sin permisos operativos | No | No | No | No | No |

Para todos los permisos, la ruta y verbo son condiciones necesarias. El gateway valida token, rol, UUID y destino. Los servicios comprueban identidad de servicio y aplican reglas de negocio. Las cabeceras `x-user-id`, `x-user-role`, `x-internal-key` enviadas por el navegador son descartadas y reconstruidas por el gateway. El despliegue local solo abre el gateway y PHP en 127.0.0.1.

## Inventario de secretos
| Referencia simbólica | Tipo | Emisor | Consumidor | Finalidad | Ubicación | Rotación |
|---|---|---|---|---|---|---|
| INTERNAL_SERVICE_KEY | clave estática académica | operador | gateway y servicios | impedir invocaciones sin identidad técnica | .env local → entorno Docker | sustituir y reiniciar contenedores |
| token hash | sesión opaca | auth | auth/introspect | autenticación usuario | SQLite de auth | expira 30m; logout revoca |
| DEMO_ADMIN_PASSWORD_HASH | hash legado opcional | operador | auth-service legado | ejemplo aislado | variable de entorno | reemplazar bajo control operador |
| JWT_SECRET | clave firma legado opcional | operador | auth-service legado | ejemplo aislado | variable de entorno | renovar y reiniciar |

**Limitaciones deliberadas:** la misma clave interna en todos los servicios no ofrece mínimos privilegios entre servicios comprometidos. Para producción usar mTLS o tokens distintos por identidad y verificación del servicio llamante. No hay gestor Vault, TLS público, limpieza automática de registros expirados ni revocación centralizada entre despliegues. No afirmar seguridad de producción.

## Rutas GraphQL
`POST /api/v1/graphql` → `graphql:8000/graphql` → resolver `myOrders` → orders GET /orders + inventory GET /products.
Query solamente; token obligatorio; profundidad máxima 5 y 40 nodos, máximo 1.800 caracteres; se niegan introspección y fragments.

## Fallos y revocación
- Si auth no responde, gateway devuelve error de dependencia, sin conceder acceso.
- Si un servicio falla, se devuelve error controlado, sin secret en la respuesta.
- Si la clave técnica se filtra, reemplazarla en .env y reiniciar todos los servicios; no dejar evidencia de la clave en capturas.
- Las sesiones se revocan con logout y vencimiento. Definir borrado de datos personales y auditoría antes de producción.
