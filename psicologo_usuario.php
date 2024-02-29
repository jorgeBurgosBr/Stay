<!DOCTYPE html>
<html lang="es">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <link rel="stylesheet" href="css/style_psico_user.css" />
   <link rel="stylesheet" href="css/style_nav_footer.css" />
   <link rel="icon" type="image/jpg" href="img/logo.png" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Stay</title>
</head>

<body>
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
               <li><a href="perfil_usuario.php">Mi perfil</a></li>
               <hr id="separacion">
               <li><a href="sesiones.php">Sesiones</a></li>
               <hr id="separacion">
               <li><a href="#" id="current_page">Mi psicólogo</a></li>
               <hr id="separacion">
               <li><a href="#">Artículos</a></li>
               <hr id="separacion">
               <li><a href="#">Foro</a></li>
               <hr id="separacion">
               <li><a href="#">Talleres</a></li>
            </ul>
         </nav>
      </div>
   </header>
   <section>
      <div class="container-mi-psico">
         <div class="info-psico">
            <div class="psico-img"></div>
            <div class="datos-personales">
               <span class="nombre-psico"></span>
               <span class="correo-psico"></span>
            </div>
            <div class="datos-personales2">
               <span class="fecha-nacimiento"></span>
               <span class="telefono-psico"></span>
            </div>
         </div>
         <div class="sobre-mi">
            <h3>Sobre mi</h3>
            <span class="descripcion"></span>
         </div>
         <div class="experiencia-especialidad">
            <h3>Experiencia y especialidad</h3>
            <span class="experiencia">años de experiencia.</span>
            <span class="especialidad"></span>
         </div>

         <div class="estudios">
            <h3>Estudios superiores</h3>
            <span class="estudios-psico"></span>
         </div>
         <div class="hobbies">
            <h3>Hobbies</h3>
            <span class="hobbies-psico"></span>
         </div>
         <div class="bttns">
         <span class="material-symbols-outlined" id="icono_chat">
            chat
         </span>
         <button type="button" id="bttn-cambiar-psico">Cambiar de psicólogo</button>
         </div>
      </div>
   </section>
   <script src="js/script_user_psico.js"></script>
</body>

</html>