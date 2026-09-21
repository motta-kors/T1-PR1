<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sabores | Gelato Artesanal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="Estilo.css">
</head>
<body>
<nav class="navbar navbar-expand-lg px-4 py-3">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="index.php">Gelato Artesanal</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu"><span class="navbar-toggler-icon"></span></button>
    <div class="collapse navbar-collapse" id="menu">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link active" href="productos.php">Sabores</a></li>
        <li class="nav-item"><a class="nav-link" href="servicios.php">FAQ</a></li>
        <li class="nav-item"><a class="nav-link" href="empresa.php">Nosotros</a></li>
        <li class="nav-item"><a class="nav-link" href="contactos.php">Contacto</a></li>
      </ul>
      <a class="btn btn-primary" href="contactos.php">Pedir online</a>
    </div>
  </div>
</nav>

<main class="container page-panel">
  <div class="text-center mb-4">
    <span class="eyebrow">Nuestros favoritos</span>
    <h1 class="fw-bold">Elige tu sabor</h1>
    <p class="text-muted">Interacción de frontend mediante parámetros de URL y JavaScript, sin backend.</p>
  </div>

  <div id="seleccionActual" class="alert gelato-alert d-none"></div>

  <div class="product-grid">
    <article class="product-card">
      <div class="product-emoji">🍫</div>
      <h2>Chocolate Belga</h2>
      <p>Intenso, cremoso y con cacao.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Chocolate%20Belga&precio=4500">Elegir · $4.500</a>
    </article>
    <article class="product-card">
      <div class="product-emoji">🍓</div>
      <h2>Frutilla Natural</h2>
      <p>Preparado con fruta real.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Frutilla%20Natural&precio=4500">Elegir · $4.500</a>
    </article>
    <article class="product-card">
      <div class="product-emoji">🥜</div>
      <h2>Pistacho</h2>
      <p>Suave, tostado y artesanal.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Pistacho&precio=5000">Elegir · $5.000</a>
    </article>
    <article class="product-card">
      <div class="product-emoji">🍋</div>
      <h2>Limón</h2>
      <p>Fresco, ligero y sin leche.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Limón&precio=4200">Elegir · $4.200</a>
    </article>
    <article class="product-card">
      <div class="product-emoji">🍪</div>
      <h2>Cookies & Cream</h2>
      <p>Helado de crema con galleta.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Cookies%20%26%20Cream&precio=4700">Elegir · $4.700</a>
    </article>
    <article class="product-card">
      <div class="product-emoji">🌿</div>
      <h2>Menta Chocolate</h2>
      <p>Menta fresca con chips de chocolate.</p>
      <a class="btn btn-primary elegir-sabor" href="productos.php?sabor=Menta%20Chocolate&precio=4700">Elegir · $4.700</a>
    </article>
  </div>

  <div class="cta mt-4">
    <h3>¿Ya elegiste?</h3>
    <p>Continúa al formulario y tu elección viajará por la URL.</p>
    <a id="continuarPedido" class="btn btn-primary" href="contactos.php">Continuar pedido</a>
  </div>
</main>

<footer class="container-fluid text-center p-4"><strong>Gelato Artesanal · 2026</strong></footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="Pagina.js"></script>
</body>
</html>