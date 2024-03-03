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
  <title>Relaciones saludables</title>
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
      <h1 class="titulo_articulo">Relaciones saludables</h1>
      <p class="parrafo_articulo">
        Construir y mantener relaciones saludables es fundamental para nuestro
        bienestar emocional y social. Las claves para relaciones exitosas
        incluyen la comunicación efectiva, el respeto mutuo y la empatía.
        Estos elementos nos ayudan a crear vínculos fuertes y significativos
        con los demás.
      </p>
      <div class="imagen_articulo">
        <img src="./img_articulos/articulo3.png" alt="" />
      </div>
      <p class="parrafo_articulo">
        Practicar la escucha activa y mostrar aprecio son aspectos esenciales
        para fortalecer cualquier relación. Además, es importante resolver
        conflictos de manera constructiva, buscando siempre el entendimiento
        mutuo.
      </p>
      <p class="parrafo_articulo">
        Conclusión: Al cultivar relaciones saludables, no solo enriquecemos
        nuestra vida sino que también contribuimos al bienestar de quienes nos
        rodean, creando así una comunidad más unida y comprensiva.
      </p>
    </div>
  </div>
  <script src="http://localhost/stay/js/script_flujo.js"></script>
  <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>