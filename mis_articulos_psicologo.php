<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
    <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
    <link rel="stylesheet" href="http://localhost/stay/css/articulos.css">
    <title>Mis Artículos</title>
</head>

<body>
    <!-- HEADER -->
    <header>
        <div class="container-nav">
            <div class="logo"></div>
            <div class="menu-toggle" id="mobile-menu">
                <img src="img/logo.png" alt="Logo" id="logo-nav" />
                <i class="ri-menu-line"></i>
            </div>
            <nav>
                <ul>
                    <img src="img/logo.png" alt="Logo" id="logo-menu" />
                    <li><a id="mi_perfil_nav">Mi perfil</a></li>
                    <hr id="separacion">
                    <li><a id="sesiones_nav">Sesiones</a></li>
                    <hr id="separacion">
                    <li><a id="psicologo_paciente_nav">
                            <?php
                            echo ($_SESSION['tipo_usuario'] == 'paciente') ? "Mi psicólogo" : "Mis pacientes";
                            ?>
                        </a></li>
                    <hr id="separacion">
                    <li><a id="articulos_nav" class="current_page">Artículos</a></li>
                    <hr id="separacion">
                    <li><a id="foro_nav">Foro</a></li>
                    <hr id="separacion">
                    <li><a id="talleres_nav">Talleres</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- FLECHA VOLVER ATRÁS -->
    <span class="material-symbols-outlined" id="arrow_back">
        arrow_back
    </span>
    <!-- ARTÍCULOS -->
    <div class="container_body_articles">
        <div class="container_search_bar">
            <div class="container_search_icon">
                <div class="material-symbols-outlined" id="search_icon">search</div>
            </div>
            <div class="search_bar">
                <input type="text" name="" id="input_search">
            </div>
        </div>
        <div id='icono_editar_articulos'>Editar artículos</div>
        <div class="container_articles">
            <!-- Los artículos se cargarán aquí dinámicamente -->
        </div>
    </div>
    <script src="http://localhost/stay/js/mis_articulos.js"></script>
    <script src="http://localhost/stay/js/script_flujo.js"></script>
    <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>