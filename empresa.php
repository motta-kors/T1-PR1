<!DOCTYPE html>
<html lang="es">

<head>
    <title>Empresa - Minecraft Web</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <link rel="stylesheet" href="css/style.css">
</head>

<body>


    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">

            <a class="navbar-brand" href="index.php">Minecraft Web</a>

            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active"
                           href="#"
                           role="button"
                           data-bs-toggle="dropdown">
                            Empresa
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item active" href="empresa.php">
                                    Quiénes Somos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Nuestro Equipo
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    Misión
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


    <div class="container mt-4">
        <div class="mc-container">
            <h1>Quiénes Somos</h1>
            <p>Conoce más sobre la historia y visión de nuestra empresa.</p>
            <a href="index.php" class="btn btn-minecraft btn-sm">Volver al Inicio</a>
        </div>
    </div>


    <footer class="container-fluid text-center text-white p-3">
        <strong>MiEmpresa@2026</strong>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>


    <script src="js/Pagina.js"></script>

</body>

</html>