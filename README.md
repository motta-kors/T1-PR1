# Gelato Artesanal 🍦

## Integrantes
- **Devid Benavides**
- **Tomás Motta**

## Descripción del proyecto
**Gelato Artesanal** es un proyecto desarrollado para la asignatura de Desarrollo Web y Móvil. Durante las distintas semanas se fue construyendo y mejorando progresivamente la estructura del sitio, su diseño visual, la interacción del frontend y posteriormente la organización de servicios mediante FastAPI, routing y API Gateway.

La versión actual mantiene separada la parte visual del sitio de la parte correspondiente a las APIs, de acuerdo con lo trabajado durante las clases.

---

## Semana 2 – Estructura inicial del sitio

Durante esta semana se creó la base del proyecto web utilizando **HTML, PHP y Bootstrap**.

Se trabajó principalmente en:

- Creación de la estructura inicial del sitio.
- Implementación de una barra de navegación.
- Creación de las páginas principales:
  - `index.php`
  - `empresa.php`
  - `servicios.php`
  - `productos.php`
  - `contactos.php`
- Uso de componentes de Bootstrap.
- Navegación entre las distintas páginas mediante enlaces.
- Primera estructura de contenido y footer.

En esta etapa el proyecto todavía utilizaba contenido de ejemplo, que posteriormente fue reemplazado por la temática definitiva de la heladería.

---

## Semana 3 – Navegación e interacción con JavaScript

Durante la Semana 3 se continuó desarrollando la estructura del sitio y se incorporó **JavaScript**.

Los principales cambios fueron:

- Incorporación del archivo `Pagina.js`.
- Mejoras en la navegación entre páginas.
- Modificaciones en las páginas de productos, contacto, empresa y servicios.
- Primeras interacciones realizadas desde el frontend.
- Organización más clara de la estructura general del proyecto.
- Uso de JavaScript para manipular elementos de la página.

Esta semana permitió pasar desde un sitio principalmente estático hacia una página con mayor interacción.

---

## Semana 4 – Diseño visual de la heladería

Durante esta semana se comenzó a definir de forma más clara la identidad visual del proyecto.

Se trabajó en:

- Creación de una propuesta gráfica para la página.
- Incorporación de una imagen de referencia del diseño.
- Creación de una paleta de colores propia.
- Uso de colores crema, verde, salvia y terracota.
- Preparación de estilos para adaptar la estructura existente a la temática de una heladería.
- Mejoras en la presentación visual del sitio.

A partir de esta etapa el proyecto comenzó a tomar la identidad de **Gelato Artesanal**.

---

## Semana 5 – API y manejo de productos

Durante la Semana 5 se comenzó a trabajar con una arquitectura que incorporaba una API.

Se implementó:

- Una API utilizando **FastAPI**.
- Archivo principal de la API en `api/main.py`.
- Dependencias necesarias para ejecutar FastAPI.
- Modificación de `productos.php`.
- Uso de JavaScript para realizar solicitudes HTTP.
- Pruebas de operaciones relacionadas con productos.
- Primer acercamiento a operaciones CRUD.
- Trabajo experimental con servicios y conexión entre frontend y API.

Esta semana sirvió como introducción al consumo de servicios desde JavaScript y al uso de FastAPI.

---

## Semana 6 – Frontend, URL, routing y API Gateway

Durante la Semana 6 se reorganizó el proyecto para separar claramente el **frontend** de la implementación de las **APIs**.

### Frontend

El frontend de **Gelato Artesanal** quedó funcionando sin depender de un backend.

Se trabajó en:

- Rediseño de la página principal.
- Unificación de colores y estilos.
- Creación de una sección de sabores.
- Página de preguntas frecuentes.
- Página de información de la heladería.
- Formulario de contacto/pedido.
- Diseño responsivo utilizando Bootstrap.
- Interacción mediante JavaScript.
- Uso de parámetros en la URL para transportar información entre páginas.

Por ejemplo:

```text
productos.php?sabor=Pistacho&precio=5000
```

JavaScript utiliza `URLSearchParams` para leer esos parámetros y mostrar la selección realizada por el usuario.

De esta manera, la interacción solicitada para el frontend se realiza utilizando **URL + JavaScript**, sin necesidad de una base de datos.

### API normal

También se creó una API independiente utilizando FastAPI.

Su estructura principal es:

```text
api_normal/
├── main.py
└── routes/
    ├── __init__.py
    └── productos.py
```

Las rutas de productos fueron separadas utilizando **APIRouter**, permitiendo mantener una estructura más organizada.

Entre las rutas disponibles se encuentran:

```text
GET /productos
GET /productos/{producto_id}
```

### API Gateway

Además se creó un **API Gateway** independiente.

Su estructura se encuentra en:

```text
api_gateway/
└── main.py
```

El Gateway recibe solicitudes y las redirige hacia la API normal.

Ejemplos:

```text
GET /api/productos
GET /api/productos/{producto_id}
```

La comunicación general queda representada de la siguiente forma:

```text
Cliente
   ↓
API Gateway
   ↓
API normal
   ↓
Routing de productos
```

---

## Tecnologías utilizadas

- HTML5
- CSS3
- JavaScript
- PHP
- Bootstrap 5
- Python
- FastAPI
- Uvicorn
- HTTPX
- Git
- GitHub

---

## Estructura principal de la versión actual

```text
T1-PR1/
│
├── index.php
├── productos.php
├── servicios.php
├── empresa.php
├── contactos.php
│
├── Estilo.css
├── Pagina.js
│
├── api_normal/
│   ├── main.py
│   └── routes/
│       ├── __init__.py
│       └── productos.py
│
├── api_gateway/
│   └── main.py
│
├── requirements.txt
└── README.md
```

---

## Ejecución de las APIs

Para instalar las dependencias:

```bash
pip install -r requirements.txt
```

Para ejecutar la API normal:

```bash
uvicorn api_normal.main:app --reload --port 8001
```

Para ejecutar el API Gateway en otra terminal:

```bash
uvicorn api_gateway.main:app --reload --port 8000
```

Documentación automática:

```text
API normal:
http://127.0.0.1:8001/docs

API Gateway:
http://127.0.0.1:8000/docs
```

---

## Estado actual

Actualmente el proyecto cuenta con un frontend completo para **Gelato Artesanal**, navegación entre páginas, diseño responsivo e interacción mediante JavaScript y parámetros de URL.

Además, el repositorio incluye una implementación separada de **API normal, routing y API Gateway**, correspondiente a los contenidos trabajados durante las últimas semanas del curso.
