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
  <!-- FLECHA VOLVER ATRÁS -->
  <span class="material-symbols-outlined" id="arrow_back">
    arrow_back
  </span>
  <!-- EDICIÓN SESIONES -->
  <div class="container_editar_sesiones">
    <div class="container_anadir">
      <h2 id="titulo_anadir">Añadir sesiones</h2>
      <div class="form_anadir">
        <form action="" id="formularioAnadir">
          <label for="select_pacientes">Selecciona un paciente:</label>
          <select name="pacientes" id="select_pacientes">
            <!-- GENERAR DINÁMICAMENTE LAS OPCIONES -->
          </select>
          <span class="" id="errorPaciente"></span>

          <label for="fecha">Selecciona una fecha:</label>
          <input type="date" id="fecha" name="fecha">
          <span class="" id="errorFecha"></span>

          <label for="hora">Selecciona una hora:</label>
          <input type="time" id="hora" name="hora">
          <span class="" id="errorHora"></span>
        </form>
        <span class="material-symbols-outlined" id="icono_anadir">shadow_add</span>
      </div>
    </div>
    <div class="container_eliminar">
      <h2 id="titulo_eliminar">Eliminar sesiones</h2>
      <div class="form_eliminar">
        <form action="" id="formularioEliminar">
          <label for="fecha">Selecciona una sesión:</label>
          <select name="sesiones" id="select_sesiones">
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
  <script src="http://localhost/stay/js/editar_sesiones.js"></script>
  <footer>
    <div class="footer-container">
      <div class="footer-column">
        <h3>Stay</h3>
        <p>Vive con esperanza</p>
        <p><i class="ri-facebook-fill"></i><i class="ri-twitter-fill"></i><i class="ri-instagram-fill"></i><i class="ri-linkedin-box-fill"></i></p>
      </div>
      <div class="footer-column">
        <h3>Quiénes somos</h3>
        <ul>
          <li><a href="#">Quiénes somos</a></li>
          <li><a href="#">Privacidad</a></li>
          <li><a href="#">Aviso legal</a></li>
          <li><a href="#">Testimonios</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h3>Otros</h3>
        <ul>
          <li><a href="#">Acerca de</a></li>
          <li><a href="#">Contacto</a></li>
          <li><a href="#">Trabaja con nosotros</a></li>
          <li><a href="#">Talleres</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h3>Soporte</h3>
        <ul>
          <li><a href="#">Chat soporte</a></li>
          <li><a href="#">Centro de ayuda</a></li>
          <li><a href="#">Reporta error</a></li>
          <li><a href="#">Cookies</a></li>
        </ul>
      </div>

      <div class="footer-column">
        <h3>Contáctanos</h3>
        <ul>
          <li><i class="ri-mail-line"></i> contacto@stay.com</li>
          <li><i class="ri-phone-line"></i> 662 223 154</li>
          <li><i class="ri-map-pin-line"></i> Calle Gran Vía, 77</li>
        </ul>
      </div>
  </footer>
</body>

</html>