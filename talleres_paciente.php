<?php
session_start();
?>
<html>

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="css/style_talleres.css" />
  <link rel="stylesheet" href="css/style_nav_footer.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Talleres</title>
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
          <li><a id="articulos_nav">Artículos</a></li>
          <hr id="separacion">
          <li><a id="foro_nav">Foro</a></li>
          <hr id="separacion">
          <li><a id="talleres_nav" class="current_page">Talleres</a></li>
        </ul>
      </nav>
    </div>
  </header>
  <!-- CONTENIDO -->
  <div class="contenedor">
    <div class="container_search_bar">
      <div class="container_search_icon">
        <div class="material-symbols-outlined" id="search_icon">search</div>
      </div>
      <div class="search_bar">
        <input type="text" name="" id="input_search">
      </div>
    </div>
    <div class="talleres">
      <!-- TARJETA1 -->
      <div class="tarjeta">
        <img src="img/talleres/taller1.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">¡Animate a nuestro gym mental!</p>
            <p class="informacion">
              El cerebro es un músculo más para ejercitar aunque no se vea a
              simple vista, ya que cuanta más importancia le demos y más
              constantes seamos, más...
            </p>
          </div>
          <div class="fecha">18/09/2023</div>
        </div>
      </div>

      <!-- TARJETA2 -->
      <div class="tarjeta">
        <img src="img/talleres/taller2.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">Espacio familiar en Salud mental</p>
            <p class="informacion">
              ¿Quién cuida de los que cuidan? El taller de Familias permite a
              las personas cuidadoras de un miembro con trastorno mental
              compartir su experiencia...
            </p>
          </div>
          <div class="fecha">24/07/2023</div>
        </div>
      </div>

      <!-- TARJETA3 -->
      <div class="tarjeta">
        <img src="img/talleres/taller3.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">Un viaje interior</p>
            <p class="informacion">
              El taller de “Conoce tu psique” es un taller en el que se
              exponen diferentes patologías mentales, sus síntomas, posibles
              causas de origen y mantenimiento, y su tratamiento. El
              objetivo...
            </p>
          </div>
          <div class="fecha">07/07/2023</div>
        </div>
      </div>

      <!-- TARJETA4 -->
      <div class="tarjeta">
        <img src="img/talleres/taller4.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">Aprender a comunicarnos</p>
            <p class="informacion">
              Las habilidades sociales conforman un conjunto de estrategias de
              conducta que permiten adecuar nuestro comportamiento a distintas
              situaciones de la vida diaria...
            </p>
          </div>
          <div class="fecha">01/02/2024</div>
        </div>
      </div>

      <!-- TARJETA5 -->
      <div class="tarjeta">
        <img src="img/talleres/taller5.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">Ejercicios para salud física y mental</p>
            <p class="informacion">
              Algunos de los ejercicios más recomendados en relación a la
              Salud Mental son: La natación desestresa y te focaliza: Nadar
              ayuda a tratar la depresión...
            </p>
          </div>
          <div class="fecha">01/02/2024</div>
        </div>
      </div>

      <!-- TARJETA6 -->
      <div class="tarjeta">
        <img src="img/talleres/taller6.png" alt="imagen taller" />
        <div class="contenido">
          <div class="encabezado">
            <p class="titulo">Mentes sanas para cuerpos sanos</p>
            <p class="informacion">
              ¿Alguna vez te has parado a escuchar a tu cuerpo? Si no lo has
              hecho aún, ¡Este es tu momento! Cuando algo no va bien, nuestro
              cuerpo puede enviarnos ciertas...
            </p>
          </div>
          <div class="fecha">26/01/2024</div>
        </div>
      </div>
    </div>
  </div>
</body>
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
<script src="js/script_talleres.js"></script>
<script src="http://localhost/stay/js/script_flujo.js"></script>
<script src="http://localhost/stay/js/script_hamburguer.js"></script>

</html>