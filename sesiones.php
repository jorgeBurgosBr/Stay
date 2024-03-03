<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/style_nav_footer.css">
   <link rel="stylesheet" href="./css/sesiones_paciente.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Sesiones</title>
</head>

<body>
   <!-- HEADER -->
   <header>
      <div class="container-nav">
         <div class="logo"></div>
         <div class="menu-toggle" id="mobile-menu">
            <img src="img/logo.png" alt="Logo" id="logo-nav"/>
            <i class="ri-menu-line"></i>
            </div>
         <nav>
            <ul>
               <img src="img/logo.png" alt="Logo" id="logo-menu"/>
               <li><a href="perfil_usuario.php">Mi perfil</a></li>
               <hr id="separacion">
               <li><a href="#" id="current_page">Sesiones</a></li>
               <hr id="separacion">
               <li><a href="#" id="mipsico_nav">Mi psicólogo</a></li>
               <hr id="separacion">
               <li><a href="articulos.php">Artículos</a></li>
               <hr id="separacion">
               <li><a href="#">Foro</a></li>
               <hr id="separacion">
               <li><a href="#">Talleres</a></li>
            </ul>
         </nav>
      </div>
   </header>
   <div class="container_sesiones">
      <!-- LISTA SESIONES -->
      <div class="container_list_sesiones">
         <div id="listaSesiones">
            <h2 id="titulo_lista">Próximas sesiones:</h2>
            <ul id="list_sesiones">

            </ul>
            <span class="material-symbols-outlined" id="icono_chat">
               chat
            </span>
         </div>
      </div>
      <!-- CALENDARIO -->
      <div class="container_cal">
         <div class="container_titulo_cal">
            <h2 id="titulo_cal"></h2>
            <span class="material-symbols-outlined" id="mesAnterior">
               chevron_left
            </span>
            <div id="calendario">
            </div>
            <span class="material-symbols-outlined" id="mesSiguiente">
               chevron_right
            </span>
         </div>
      </div>
   </div>
   <script src="./js/sesiones_paciente.js"></script>
   <script src="js/script_flujo.js"></script>
   <script src="./js/script_hamburguer.js"></script>
</body>

</html>