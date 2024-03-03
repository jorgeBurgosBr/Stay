<?php
session_start();
require_once 'php/conecta.php';

$id_psicologo = $_SESSION['id_paciente'];
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');

$sql = "SELECT p.*, pp.* 
        FROM psicologo p 
        JOIN perfil_psicologo pp ON pp.id_psicologo = p.id_psicologo 
        WHERE p.id_psicologo = ?";

// Preparar la sentencia
if ($stmt = mysqli_prepare($conn, $sql)) {
   // Vincular parámetros
   mysqli_stmt_bind_param($stmt, "i", $id_psicologo);

   // Ejecutar la consulta
   if (mysqli_stmt_execute($stmt)) {
      // Obtener resultados
      $result = mysqli_stmt_get_result($stmt);

      if (mysqli_num_rows($result) > 0) {
         $row = mysqli_fetch_assoc($result);
      }
   } else {
      // Error en la ejecución de la consulta
      echo "Error en la ejecución de la consulta: " . mysqli_stmt_error($stmt);
   }
   // Cerrar la sentencia
   mysqli_stmt_close($stmt);
} else {
   // Error en la preparación de la consulta SQL
   echo "Error en la preparación de la consulta SQL: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Realtime Chat App</title>
   <link rel="stylesheet" href="css/style_chat.css" />
   <link rel="stylesheet" href="css/style_nav_footer.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
   <!-- navbar -->
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
               <li><a href="#">Mi perfil</a></li>
               <hr id="separacion">
               <li><a href="sesiones.php">Sesiones</a></li>
               <hr id="separacion">
               <li><a href="#" id="mipsico_nav" id="current_page">Mi psicólogo</a></li>
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
   <div class="body">
      <div class="wrapper">
         <section class="users">
            <div class="header">
               <div class="content">

                  <img src="<?php echo $row['foto_psicologo'] ?>" alt="foto psicólogo" />

                  <div class="details">
                     <span><?php echo $row['nombre_psicologo'] . " " . $row['apellidos_psicologo'] ?></span>
                  </div>
               </div>
            </div>
            <div class="search">
               <span class="text">Seleciona un paciente para empezar a hablar</span>
               <input type="text" placeholder="Introduce nombre para buscar..." />
               <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">

            </div>
         </section>
      </div>
      <script src="js/users.js"></script>
   </div>
</body>

</html>