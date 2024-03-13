<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../css/entrada_articulo.css" />
  <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
  <title>Gestión del estrés en el trabajo</title>
</head>

<body>
  <!-- HEADER -->
  <header>
    <div class="container-nav">
      <div class="logo"></div>
      <div class="menu-toggle" id="mobile-menu">
        <img src="http://localhost/stay/img/logo.png" alt="Logo" id="logo-nav" />
        <i class="ri-menu-line"></i>
      </div>
      <nav>
        <ul>
          <img src="http://localhost/stay/img/logo.png" alt="Logo" id="logo-menu" />
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
  <!-- ARTÍCULO -->
  <div class="container_articulo">
    <div class="articulo">
      <h1 class="titulo_articulo">Gestión del estrés en el trabajo</h1>
      <p class="parrafo_articulo">
        El estrés laboral se ha convertido en una preocupación creciente para
        muchas personas en el mundo contemporáneo. La presión por cumplir con
        plazos, las largas jornadas de trabajo y el equilibrio entre la vida
        laboral y personal pueden ser abrumadores. Sin embargo, existen
        estrategias efectivas para manejar este estrés y recuperar la paz mental.
      </p class="parrafo_articulo">
      <div class="imagen_articulo">
        <img src="./img_articulos/articulo2.png" alt="" />
      </div>
      <p class="parrafo_articulo">
        Una técnica eficaz es la práctica regular de mindfulness en el trabajo,
        que puede ayudar a mantener la calma en situaciones estresantes. Además,
        establecer límites claros entre el trabajo y la vida personal es crucial
        para mantener el bienestar.
      </p>
      <p class="parrafo_articulo">
        Conclusión: Aprender a gestionar el estrés en el trabajo no solo mejora
        nuestra salud mental y física, sino que también incrementa nuestra
        productividad y satisfacción laboral.
      </p>
    </div>
  </div>
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
  <script src="http://localhost/stay/js/script_flujo.js"></script>
  <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>