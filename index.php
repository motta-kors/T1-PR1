<!DOCTYPE html>
<html lang="es">

<head>
    <title>Minecraft Web</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="style.css">
</head>

<body>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">

        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">Logo</a>

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

            <button type="button"
                    class="btn btn-outline-info"
                    data-bs-toggle="modal"
                    data-bs-target="#myModal">

                Acceder

            </button>

        </div>

    </nav>



    <div class="container-fluid p-4"
         style="background-color: turquoise; min-height: 500px;">

        <h1>Pagina Principal</h1>

        <p>Bienvenido a Minecraft Web</p>

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

                <strong>MiEmpresa@2026</strong>

            </div>

            <div class="col-4"></div>

        </div>

    </div>



    <div class="modal fade" id="myModal">

        <div class="modal-dialog">

            <div class="modal-content">


                <div class="modal-header">

                    <h4 class="modal-title">
                        Autenticacion
                    </h4>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>

                </div>



                <div class="modal-body">

                    <form action="empresa.php">

                        <div class="mb-3">

                            <label for="email" class="form-label">
                                Email:
                            </label>

                            <input type="email"
                                   class="form-control"
                                   id="email"
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



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <script src="js/Pagina.js"></script>

</body>

</html>