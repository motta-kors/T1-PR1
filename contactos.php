<!DOCTYPE html>
<html lang="es">

<head>
    <title>Pagina Contacto</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSS propio -->
    <link rel="stylesheet" href="Estilo.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">Gelato Artesanal</a>

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
                        <a class="nav-link active" href="contactos.php">
                            Contacto
                        </a>
                    </li>

                </ul>

            </div>

            <button type="button"
                    class="btn btn-outline-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#myModal">
                Acceder
            </button>

        </div>
    </nav>

    <!-- Container -->
    <div class="container page-panel">

        <h1>Contacto</h1>

        <form action="empresa.php" method="post">

            <div class="mb-3">

                <label for="contactEmail" class="form-label">
                    Email:
                </label>

                <input type="email"
                       class="form-control"
                       id="contactEmail"
                       placeholder="Ingrese su email"
                       name="email">

            </div>

            <div class="mb-3">

                <label for="comment" class="form-label">
                    Comentarios:
                </label>

                <textarea class="form-control"
                          rows="5"
                          id="comment"
                          name="text"></textarea>

            </div>

            <button type="submit" class="btn btn-outline-primary">
                Enviar
            </button>

            <a href="index.php" class="btn btn-outline-dark">
                Volver
            </a>

        </form>

    </div>

    <!-- Footer -->
    <div class="container-fluid bg-dark p-3">

        <div class="row">

            <div class="col-4"></div>

            <div class="col-4 text-center text-white">
                <strong>Gelato Artesanal · 2026</strong>
            </div>

            <div class="col-4"></div>

        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal">

        <div class="modal-dialog">

            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title">
                        Autenticacion
                    </h4>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <form action="empresa.php" method="post">

                        <div class="mb-3">

                            <label for="loginEmail" class="form-label">
                                Email:
                            </label>

                            <input type="email"
                                   class="form-control"
                                   id="loginEmail"
                                   placeholder="Ingrese su email"
                                   name="email">

                        </div>

                        <div class="mb-3">

                            <label for="pwd" class="form-label">
                                Password:
                            </label>

                            <input type="password"
                                   class="form-control"
                                   id="pwd"
                                   placeholder="Ingrese su password"
                                   name="pswd">

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

                <!-- Modal footer -->
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