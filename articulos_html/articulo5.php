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
  <title>Desarrollo personal a través de la psicología</title>
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
  <div class="container_articulo">
    <div class="articulo">
      <h1 class="titulo_articulo">
        Desarrollo personal a través de la psicología
      </h1>
      <p class="parrafo_articulo">
        La psicología, como ciencia del comportamiento y los procesos
        mentales, ofrece herramientas valiosas para el desarrollo personal.
        Comprender cómo funcionan nuestras mentes nos permite identificar
        patrones de pensamiento y comportamiento que podemos modificar para
        mejorar nuestra vida.
      </p>
      <div class="imagen_articulo">
        <img src="./img_articulos/articulo5.png" alt="" />
      </div>
      <p class="parrafo_articulo">
        A través del autoconocimiento y técnicas como la terapia
        cognitivo-conductual, podemos superar obstáculos psicológicos y
        avanzar hacia el logro de nuestros objetivos personales y
        profesionales.
      </p>
      <p class="parrafo_articulo">
        Conclusión: El desarrollo personal es un viaje continuo de
        autoexploración y crecimiento. La psicología proporciona el mapa que
        nos guía en este viaje, ayudándonos a alcanzar nuestro máximo
        potencial.
      </p>
    </div>
  </div>
  <script src="http://localhost/stay/js/script_flujo.js"></script>
  <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>