<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Tienda segura | Minecraft Web</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="Estilo.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark"><div class="container">
<a class="navbar-brand" href="index.php">Minecraft Web</a>
<div class="d-flex gap-3"><a class="text-white" href="productos.php">Productos originales</a><a class="text-white" href="contactos.php">Contacto</a></div>
</div></nav>
<main class="container my-4">
<h1>Tienda y pedidos</h1><p>Catálogo de prueba integrado con los servicios privados. Los pagos son simulados: no hay cobros reales.</p>
<div id="estado" class="alert alert-secondary" role="status">Consultando catálogo...</div>
<div class="row g-4">
<section class="col-lg-7"><h2 class="h4">Catálogo</h2><div id="catalogo" class="row g-3"></div></section>
<section class="col-lg-5">
<div class="card text-dark mb-3"><div class="card-body">
<h2 class="h5">Crear cuenta</h2>
<form id="registro" class="vstack gap-2"><input class="form-control" name="name" required placeholder="Nombre">
<input class="form-control" name="email" type="email" required placeholder="Correo">
<input class="form-control" name="password" type="password" minlength="10" required placeholder="Contraseña (10+ caracteres)">
<button class="btn btn-success">Registrarse</button></form>
</div></div>
<div class="card text-dark mb-3"><div class="card-body">
<h2 class="h5">Iniciar sesión</h2>
<form id="login" class="vstack gap-2"><input class="form-control" name="email" type="email" required placeholder="Correo">
<input class="form-control" name="password" type="password" required placeholder="Contraseña">
<button class="btn btn-primary">Acceder</button></form>
<button id="salir" class="btn btn-link" type="button">Cerrar sesión</button>
</div></div>
<div class="card text-dark mb-3"><div class="card-body">
<h2 class="h5">Mis pedidos</h2><button id="recargar" class="btn btn-outline-dark mb-2">Actualizar pedidos</button>
<ul id="pedidos" class="list-group"></ul></div></div>
<div class="card text-dark"><div class="card-body">
<h2 class="h5">Administrar catálogo</h2>
<p class="small">Solo funciona con una cuenta de administrador creada desde el servidor.</p>
<form id="producto" class="vstack gap-2"><input class="form-control" name="name" required placeholder="Producto">
<input class="form-control" name="price" type="number" min="0" required placeholder="Precio en CLP">
<input class="form-control" name="stock" type="number" min="0" required placeholder="Stock">
<button class="btn btn-dark">Agregar producto</button></form>
</div></div>
</section></div>
</main>
<footer class="bg-dark text-white text-center p-3 mt-auto">MiEmpresa@2026 · Demostración académica</footer>
<script src="tienda-segura.js"></script>
</body></html>