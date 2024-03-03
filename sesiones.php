<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="./css/sesiones_paciente.css">
   <link rel="stylesheet" href="http://localhost/stay/css/style_nav_footer.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.1.0/remixicon.css">
   <title>Sesiones</title>
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
   <div class="container_sesiones">
      <!-- LISTA SESIONES -->
      <div class="container_list_sesiones">
         <div id="listaSesiones">
            <h2 id="titulo_lista">Próximas sesiones:</h2>
            <ul id="list_sesiones">

            </ul>
            <div class="container_iconos">
               <span class="material-symbols-outlined" id="icono_chat" data-tipo='<?php echo $_SESSION['tipo_usuario']; ?>'>
                  chat
               </span>
               <?php
               echo ($_SESSION['tipo_usuario'] == 'psicologo') ? "<span class='material-symbols-outlined' id='icono_editar'>edit_calendar</span>" : "";

               ?>
            </div>
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
   <script src="http://localhost/stay/js/sesiones_paciente.js"></script>
   <script src="http://localhost/stay/js/script_flujo.js"></script>
   <script src="http://localhost/stay/js/script_hamburguer.js"></script>
</body>

</html>