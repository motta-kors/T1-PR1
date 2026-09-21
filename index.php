<!DOCTYPE html>
<html lang="es">
<head>
    <title>Gelato Artesanal</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Estilo.css">
</head>
<body>
    <div class="site-shell">
        <nav class="navbar navbar-expand-lg px-4 py-3">
            <div class="container-fluid">
                <a class="navbar-brand fw-bold lh-sm" href="index.php">Gelato<br>Artesanal</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav mx-auto gap-lg-3">
                        <li class="nav-item"><a class="nav-link active" href="index.php">Inicio</a></li>
                        <li class="nav-item"><a class="nav-link" href="productos.php">Sabores</a></li>
                        <li class="nav-item"><a class="nav-link" href="#formatos">Formatos</a></li>
                        <li class="nav-item"><a class="nav-link" href="servicios.php">FAQ</a></li>
                        <li class="nav-item"><a class="nav-link" href="contactos.php">Contacto</a></li>
                    </ul>
                    <div class="d-flex align-items-center gap-3">
                        <i class="bi bi-search"></i>
                        <i class="bi bi-cart3"></i>
                        <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#myModal">Pedir Online</button>
                    </div>
                </div>
            </div>
        </nav>

        <section class="hero">
            <div>
                <div class="eyebrow"><span>⭐ 4.9/5</span><small>(1.200 reseñas)</small></div>
                <h1>El auténtico sabor artesanal en cada cucharada</h1>
                <p>Cremosos, naturales y hechos con dedicación. Una propuesta fresca inspirada en sabores clásicos y combinaciones únicas.</p>
                <div class="hero-stats">
                    <div><strong>100%</strong><span>Ingredientes naturales</span></div>
                    <div><strong>0%</strong><span>Colorantes artificiales</span></div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="productos.php" class="btn btn-primary px-4">Pide Ahora</a>
                    <a href="#formatos" class="btn btn-outline-dark px-4">Explora Sabores</a>
                </div>
            </div>
            <div class="hero-art">
                <div class="gelato-cup">
                    <div class="cup-label">Gelato<br>Artesanal</div>
                </div>
            </div>
        </section>

        <section class="section-block" id="formatos">
            <h2 class="section-title">Descubre nuestros formatos</h2>
            <div class="format-grid">
                <article class="format-card">
                    <div class="format-visual">🍦</div>
                    <h3>Cono Doble Barquillo</h3>
                    <p class="text-muted mb-3">Elige tus 2 sabores favoritos.</p>
                    <span class="price-pill">Agregar · $4.500</span>
                </article>
                <article class="format-card">
                    <div class="format-visual">🍨</div>
                    <h3>Pote Familiar 1000ml</h3>
                    <p class="text-muted mb-3">Hasta 4 sabores.</p>
                    <span class="price-pill">Agregar · $9.900</span>
                </article>
                <article class="format-card">
                    <div class="format-visual">🥣</div>
                    <h3>Pote Mediano 500ml</h3>
                    <p class="text-muted mb-3">Hasta 2 sabores.</p>
                    <span class="price-pill">Agregar · $5.900</span>
                </article>
            </div>
        </section>

        <section class="special">
            <div class="special-visual">🍧</div>
            <div>
                <small class="text-uppercase fw-bold">Pote especial</small>
                <h2 class="fw-bold">Pistacho y frutos del bosque</h2>
                <p>Artesanal · Fruta fresca · Sin gluten</p>
                <h3 class="fw-bold">$6.500</h3>
                <a href="productos.php" class="btn btn-primary mt-2">Ver sabores</a>
            </div>
        </section>

        <section class="section-block pt-2">
            <h2 class="section-title">Por qué te encantará nuestro helado</h2>
            <div class="benefits">
                <div class="benefit"><div class="fs-2">🍓</div><strong>Fruta 100% real</strong></div>
                <div class="benefit"><div class="fs-2">🔥</div><strong>Cremado tradicional</strong></div>
                <div class="benefit highlight"><div class="fs-2">♻️</div><strong>Envases eco-friendly</strong></div>
                <div class="benefit"><div class="fs-2">🌱</div><strong>Línea vegana</strong></div>
            </div>
            <div class="cta">
                <h3>¿Se te antoja un helado hoy?</h3>
                <p>Pide online y recíbelo listo.</p>
                <a href="contactos.php" class="btn btn-primary px-4">Hacer Pedido</a>
            </div>
        </section>
    </div>

    <footer class="container-fluid text-center p-4">
        <strong>Gelato Artesanal · 2026</strong>
    </footer>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pedido Online</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="productos.php">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" placeholder="Ingrese su email" name="email">
                        </div>
                        <button type="submit" class="btn btn-primary">Continuar pedido</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>