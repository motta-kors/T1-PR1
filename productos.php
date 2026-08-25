<!DOCTYPE html>
<html lang="es">

<head>
    <title>Pagina Productos</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.html">Logo</a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">

                <ul class="navbar-nav">

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Empresa
                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="empresa.html">
                                    Quienes Somos
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Nuestro Equipo
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="#">
                                    Mision
                                </a>
                            </li>

                        </ul>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="servicios.html">
                            Servicios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="productos.html">
                            Productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contactos.html">
                            Contacto
                        </a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>


    <div class="container-fluid bg-warning p-4">
        <h1>Pagina Productos</h1>
        <p>Gestión y catálogo de productos</p>
        <a href="index.html" class="btn btn-outline-dark btn-sm">Volver a Principal</a>
    </div>


    <div class="container my-4">
        <div class="card p-4 shadow-sm">
            <h4 class="card-title mb-3">Agregar Nuevo Producto</h4>

            <div class="mb-3">
                <label for="txtId" class="form-label">ID del Producto:</label>
                <input type="text" id="txtId" class="form-control" placeholder="Ej: 3">
            </div>

            <div class="mb-3">
                <label for="txtNombre" class="form-label">Nombre del Producto:</label>
                <input type="text" id="txtNombre" class="form-control" placeholder="Ej: Monitor Gamer">
            </div>

            <button type="button" class="btn btn-primary mb-3" onclick="agregarProducto()">
                Agregar Producto
            </button>

            <hr>

            <div class="mb-3">
                <label for="cmbProducto" class="form-label">Lista de Productos Registrados:</label>
                <select id="cmbProducto" name="cmbProducto" class="form-select">

                </select>
            </div>
        </div>
    </div>


    <div class="container-fluid bg-dark p-3">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4 text-center" style="color:white;">
                <strong>MiEmpresa@2026</strong>
            </div>
            <div class="col-4"></div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <script src="js/Pagina.js"></script>

</body>

</html>