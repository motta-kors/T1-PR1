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

                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            Inicio
                        </a>
                    </li>

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

            <button type="button"
                    class="btn btn-outline-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#myModal">

                Acceder
            </button>

        </div>
    </nav>


    <!-- Contenido principal -->
    <div class="container-fluid p-4"
         style="background-color: orange; min-height: 500px;">

        <h1>Los Dos de Tamaulipas</h1>

        <p>Bienvenido a la pagina de Los Dos de Tamaulipas</p>

        <hr>

        <a href="empresa.php" class="btn btn-dark m-1">
            Empresa
        </a>

        <a href="servicios.php" class="btn btn-dark m-1">
            Servicios
        </a>

        <a href="productos.php" class="btn btn-dark m-1">
            Productos
        </a>

        <a href="contactos.php" class="btn btn-dark m-1">
            Contacto
        </a>

    </div>


    <!-- Footer -->
    <footer class="container-fluid bg-dark text-white text-center p-3">

        <strong>Los Dos de Tamaulipas © 2026</strong>

    </footer>


    <!-- Modal de acceso -->
    <div class="modal fade" id="myModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header">

                    <h4 class="modal-title">
                        Autenticacion
                    </h4>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>


                <!-- Body -->
                <div class="modal-body">

                    <form action="empresa.php" method="post">

                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email:
                            </label>

                            <input type="email"
                                   class="form-control"
                                   id="email"
                                   name="email"
                                   placeholder="Ingrese su email"
                                   required>

                        </div>

                        <div class="mb-3">

                            <label for="pwd" class="form-label">
                                Password:
                            </label>

                            <input type="password"
                                   class="form-control"
                                   id="pwd"
                                   name="pswd"
                                   placeholder="Ingrese su password"
                                   required>

                        </div>

                        <div class="form-check mb-3">

                            <input class="form-check-input"
                                   type="checkbox"
                                   id="remember"
                                   name="remember">

                            <label class="form-check-label" for="remember">
                                Recordarme
                            </label>

                        </div>

                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>

                    </form>

                </div>


                <!-- Footer Modal -->
                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-danger"
                            data-bs-dismiss="modal">

                        Cerrar

                    </button>

                </div>

            </div>

        </div>

    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS propio -->
    <script src="js/app.js"></script>

</body>

</html>