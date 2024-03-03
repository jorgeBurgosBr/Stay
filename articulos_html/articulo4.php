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
  <title>El poder del pensamiento positivo</title>
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
      <h1 class="titulo_articulo">El poder del pensamiento positivo</h1>
      <p class="parrafo_articulo">
        El pensamiento positivo va más allá de un simple optimismo
        superficial. Se trata de adoptar una actitud que nos permite enfrentar
        los desafíos de la vida con confianza y buscar soluciones en lugar de
        lamentarse por los problemas. Esta mentalidad puede transformar
        nuestra experiencia vital de manera profunda.
      </p>
      <div class="imagen_articulo">
        <img src="./img_articulos/articulo4.png" alt="" />
      </div>
      <p class="parrafo_articulo">
        La ciencia ha demostrado que el pensamiento positivo puede mejorar
        nuestra salud física y mental, reduciendo el estrés y aumentando la
        longevidad. Además, fomenta relaciones más saludables y aumenta la
        satisfacción personal.
      </p>
      <p class="parrafo_articulo">
        Conclusión: Adoptar el pensamiento positivo no solo mejora nuestra
        calidad de vida, sino que también potencia nuestra capacidad para
        lograr nuestros objetivos y enfrentar adversidades.
      </p>
    </div>
  </div>
  <script src="http://localhost/stay/js/script_flujo.js"></script>
  <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>