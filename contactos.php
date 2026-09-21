<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Contacto | Gelato Artesanal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="Estilo.css">
</head>
<body>
<nav class="navbar navbar-expand-lg px-4 py-3">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Gelato Artesanal</a>
    <div class="navbar-nav ms-auto">
      <a class="nav-link" href="index.php">Inicio</a>
      <a class="nav-link" href="productos.php">Sabores</a>
      <a class="nav-link" href="servicios.php">FAQ</a>
      <a class="nav-link" href="empresa.php">Nosotros</a>
      <a class="nav-link active" href="contactos.php">Contacto</a>
    </div>
  </div>
</nav>

<main class="container page-panel">
  <div class="row g-4 align-items-start">
    <div class="col-lg-5">
      <span class="eyebrow">Pedido online</span>
      <h1 class="fw-bold">Cuéntanos qué quieres pedir</h1>
      <p>Este formulario funciona solo en frontend. JavaScript valida los datos, muestra mensajes y actualiza la URL, sin enviar información a un servidor.</p>
      <div id="resumenPedido" class="gelato-alert p-3 rounded-4"></div>
    </div>
    <div class="col-lg-7">
      <form id="formPedido" novalidate>
        <div class="mb-3">
          <label class="form-label" for="nombre">Nombre <span aria-hidden="true">*</span></label>
          <input class="form-control" id="nombre" name="nombre" type="text" minlength="2" maxlength="60" autocomplete="name" required aria-describedby="errorNombre">
          <div id="errorNombre" class="invalid-feedback">Ingresa tu nombre (mínimo 2 caracteres).</div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="email">Email <span aria-hidden="true">*</span></label>
          <input type="email" class="form-control" id="email" name="email" maxlength="120" autocomplete="email" required aria-describedby="errorEmail">
          <div id="errorEmail" class="invalid-feedback">Ingresa un correo válido, por ejemplo nombre@correo.cl.</div>
        </div>

        <div class="mb-3">
          <label class="form-label" for="mensaje">Comentario</label>
          <textarea class="form-control" id="mensaje" name="mensaje" rows="4" maxlength="250" placeholder="Ej: 2 potes de 500 ml" aria-describedby="contadorMensaje"></textarea>
          <div id="contadorMensaje" class="form-text text-end">0 / 250 caracteres</div>
        </div>

        <div id="erroresFormulario" class="alert alert-danger d-none" role="alert" aria-live="polite"></div>

        <button class="btn btn-primary" type="submit">Simular pedido</button>
        <a class="btn btn-outline-dark" href="productos.php">Volver a sabores</a>
      </form>
      <div id="confirmacionPedido" class="alert gelato-alert mt-3 d-none" role="status" aria-live="polite"></div>
    </div>
  </div>
</main>

<footer class="container-fluid text-center p-4"><strong>Gelato Artesanal · 2026</strong></footer>
<script src="Pagina.js"></script>
</body>
</html>