<!DOCTYPE html>
<html lang="es">

<head>
    <title>Los Dos de Tamaulipas</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

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

                    <li class="nav-item dropdown">

                        <a class="nav-link dropdown-toggle"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">

                            Empresa

                        </a>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="empresa.php">
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
                        <a class="nav-link" href="servicios.php">
                            Servicios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">
                            Productos
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

        <h1>Los Dos de Tamaulipas</h1>

        <p>Bienvenido a la pagina de Los Dos de Tamaulipas</p>

        <a href="empresa.php">Ir a Empresa</a><br>

        <a href="servicios.php">Ir a Servicios</a><br>

        <a href="productos.php">Ir a Productos</a><br>

        <a href="contactos.php">Ir a Contacto</a><br>

    </div>


    <!-- Footer -->
    <div class="container-fluid bg-dark p-3">

        <div class="row">

            <div class="col-4"></div>

            <div class="col-4 text-center text-white">

                <strong>Los Dos de Tamaulipas © 2026</strong>

            </div>

            <div class="col-4"></div>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS propio -->
    <script src="js/app.js"></script>

</body>

</html>