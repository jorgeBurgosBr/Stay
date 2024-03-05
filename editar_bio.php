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
   <!-- BODY -->
   <div class="contenedor">
      <div class="informacion">
         <img src="img/paciente/jim_paciente.png" alt="">
         <p class="nombre">Jim Beam</p>
         <p class="edad">33 / hombre</p>
      </div>
      <div class="bio">
         <textarea name="" id="">Mikasa Trovsky, una joven de 23 años, lleva consigo una historia de dolor y superación. Tras perder a su familia, ha emergido como una influyente en el mundo digital, especializándose en bienestar mental, fitness y moda. Su apariencia es un reflejo de su fortaleza interior: estatura media, físico atlético, cabello oscuro y ojos avellana que destilan una mezcla de sabiduría y melancolía. Mikasa combina madurez y seriedad con un toque de ironía en su humor. Aunque exitosa en las redes, mantiene su vida personal en reserva, optando por compartir solo aquello que pueda inspirar y ayudar a otros. Su estilo es un equilibrio de elegancia y comodidad, con tonos neutros y accesorios discretos.</textarea>
      </div>
   </div>


</body>

</html>