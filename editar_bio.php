<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="./css/style_editar_bio.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Pacientes Psicólogo</title>
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
               <li><a id="psicologo_paciente_nav" class="current_page">
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
   <!-- BODY -->
   <div class="contenedor">
   </div>


</body>
<script src="http://localhost/stay/js/script_flujo.js"></script>
<script src="http://localhost/stay/js/script_hamburguer.js"></script>
<script src="http://localhost/stay/js/script_editar_bio.js"></script>

</html>