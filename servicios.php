<!DOCTYPE html>
<html lang="es">

<head>
    <title>Servicios - Los Dos de Tamaulipas</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS propio -->
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">
                Los Dos de Tamaulipas
            </a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">

                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">

                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            Principal
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="empresa.php">
                            Empresa
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">
                            Productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="servicios.php">
                            Servicios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="contactos.php">
                            Contacto
                        </a>
                    </li>

                </ul>

            </div>

        </div>
    </nav>

    <!-- Contenido -->
    <div class="container-fluid p-4"
         style="background-color: orange; min-height: 500px;">

        <h1>Servicios</h1>

        <p>
            Bienvenido a la página de servicios de Los Dos de Tamaulipas.
        </p>

        <a href="index.php" class="btn btn-dark">
            Volver a Principal
        </a>

    </div>

    <!-- Footer -->
    <footer class="container-fluid bg-dark text-white text-center p-3">

        <strong>Los Dos de Tamaulipas © 2026</strong>

    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS propio -->
    <script src="js/app.js"></script>

</body>

</html>