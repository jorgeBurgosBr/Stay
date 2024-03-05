<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
    <link rel="stylesheet" href="http://localhost/stay/css/editar_sesiones.css">
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
    <div class="container_editar_sesiones">
        <div class="container_anadir">
            <h2 id="titulo_anadir">Añadir artículos</h2>
            <div class="form_anadir">
                <form action="" id="formularioAnadir">
                    <label for="input_archivo">Selecciona un archivo html:</label>
                    <input type="file" name="input_archivo" id="input_archivo">
                    <span class="" id="errorPaciente"></span>
                </form>
                <span class="material-symbols-outlined" id="icono_anadir">shadow_add</span>
            </div>
        </div>
        <div class="container_eliminar">
            <h2 id="titulo_eliminar">Eliminar artículos</h2>
            <div class="form_eliminar">
                <form action="" id="formularioEliminar">
                    <label for="select_sesiones">Selecciona un artículo:</label>
                    <select name="" id="select_sesiones">
                        <!-- GENERAR DINÁMICAMENTE LAS OPCIONES -->
                    </select>
                    <span class="" id="errorSesion"></span>
                </form>
                <span class="material-symbols-outlined" id="icono_eliminar">
                    shadow_minus
                </span>
            </div>
        </div>
    </div>
    <script src="http://localhost/stay/js/script_flujo.js"></script>
    <script src="http://localhost/stay/js/script_hamburguer.js"></script>
    <script src="http://localhost/stay/js/editar_articulos.js"></script>
</body>

</html>