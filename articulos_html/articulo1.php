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
  <title>La importancia del mindfulness</title>
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
      <h1 class="titulo_articulo">La importancia del mindfulness</h1>
      <p class="parrafo_articulo">
        El mindfulness, o atención plena, es una práctica milenaria que ha
        ganado popularidad en el mundo moderno debido a sus múltiples
        beneficios para la salud mental y física. Consiste en la capacidad de
        estar plenamente presentes, conscientes de dónde estamos y qué estamos
        haciendo, sin reaccionar de forma excesiva o abrumadora a lo que
        sucede a nuestro alrededor.
      </p>
      <div class="imagen_articulo">
        <img src="./img_articulos/articulo1.png" alt="" />
      </div>
      <p class="parrafo_articulo">
        La investigación ha demostrado que el mindfulness puede reducir
        significativamente el estrés, la ansiedad y la depresión. Además,
        fomenta un mayor sentido de calma y ayuda a desarrollar una actitud
        más positiva ante la vida.
      </p>
      <p class="parrafo_articulo">
        Conclusión: Incorporar el mindfulness en nuestra rutina diaria puede
        transformar nuestra relación con nosotros mismos y con el mundo que
        nos rodea, llevándonos a una vida más serena, consciente y
        equilibrada.
      </p>
    </div>
  </div>
  <script src="http://localhost/stay/js/script_flujo.js"></script>
  <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>