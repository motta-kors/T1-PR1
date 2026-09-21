<!DOCTYPE html>
<html lang="es">

<head>
    <title>Productos</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="Estilo.css">
</head>

<body>

    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Minecraft Web</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Principal</a></li>
                    <li class="nav-item"><a class="nav-link" href="empresa.php">Empresa</a></li>
                    <li class="nav-item"><a class="nav-link" href="servicios.php">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link active" href="productos.php">Productos</a></li>
                    <li class="nav-item"><a class="nav-link" href="contactos.php">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        <div class="mc-container">
            <h1>Productos</h1>
            <p>
                CRUD conectado a FastAPI y MongoDB. Selecciona un producto para cargar sus datos,
                o utiliza el formulario para agregar uno nuevo.
            </p>

            <div class="mb-4">
                <label for="cmbProducto" class="form-label">Productos disponibles</label>
                <select id="cmbProducto" class="form-select">
                    <option value="">Cargando productos...</option>
                </select>
            </div>

            <h2 class="h4">Datos del producto</h2>

            <div class="row g-3">
                <div class="col-md-3">
                    <label for="txtId" class="form-label">ID</label>
                    <input type="number" id="txtId" class="form-control" min="1">
                </div>

                <div class="col-md-5">
                    <label for="txtNombre" class="form-label">Nombre</label>
                    <input type="text" id="txtNombre" class="form-control">
                </div>

                <div class="col-md-4">
                    <label for="txtPrecio" class="form-label">Precio</label>
                    <input type="number" id="txtPrecio" class="form-control" min="1">
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2 mt-3">
                <button type="button" class="btn btn-minecraft" onclick="agregarProducto()">
                    <i class="bi bi-plus-circle"></i> Agregar
                </button>

                <button type="button" class="btn btn-warning" onclick="actualizarProducto()">
                    <i class="bi bi-pencil-square"></i> Actualizar
                </button>

                <button type="button" class="btn btn-danger" onclick="eliminarProducto()">
                    <i class="bi bi-trash"></i> Eliminar
                </button>

                <button type="button" class="btn btn-outline-light" onclick="limpiarFormulario()">
                    Limpiar
                </button>
            </div>

            <hr>

            <p class="mb-0">
                Documentación de la API:
                <code>http://127.0.0.1:8000/docs</code>
            </p>
        </div>
    </main>

    <footer class="container-fluid text-white text-center p-3">
        <strong>MiEmpresa@2026</strong>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="Pagina.js"></script>

</body>
</html>
