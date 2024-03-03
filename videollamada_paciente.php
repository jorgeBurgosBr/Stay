<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/videollamada_paciente.css">
    <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
    <title>Document</title>
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
                    <li><a id="sesiones_nav" class="current_page">Sesiones</a></li>
                    <hr id="separacion">
                    <li><a id="psicologo_paciente_nav">
                            <?php
                            echo ($_SESSION['tipo_usuario'] == 'paciente') ? "Mi psicólogo" : "Mis pacientes";
                            ?>
                        </a></li>
                    <hr id="separacion">
                    <li><a id="articulos_nav">Artículos</a></li>
                    <hr id="separacion">
                    <li><a id="foro_nav">Foro</a></li>
                    <hr id="separacion">
                    <li><a id="talleres_nav">Talleres</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <!-- VIDEOLLAMADA -->
    <div class="container_videollamada">
        <div class="camera_section"></div>
        <div class="control_panel">
            <div class="material-symbols-outlined mic switch">mic</div>
            <div class="material-symbols-outlined camera switch">videocam</div>
            <div class="material-symbols-outlined call switch">call</div>
            <div class="material-symbols-outlined settings switch">settings</div>
            <div class="material-symbols-outlined fullscreen switch">fullscreen</div>
        </div>
        <div class="camera_section"></div>
    </div>
    <script src="./js/videollamada_paciente.js"></script>
    <script src="http://localhost/stay/js/script_flujo.js"></script>
    <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>