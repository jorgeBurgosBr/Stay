<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   if ($_SERVER["REQUEST_METHOD"] == 'POST') {

      $respuesta = [
         "success" => false,
         "error" => null
      ];

      $correo = mysqli_real_escape_string($conn, $_POST['correo']);
      $password = mysqli_real_escape_string($conn, $_POST['password_login']);

      // Comprobamos si el correo es correcto
      $sql = mysqli_query($conn, "SELECT contrasena_usuario FROM usuario WHERE correo_usuario = '$correo'");
      if ($fila = mysqli_fetch_assoc($sql)) {
         // La función password_verify compara la contraseña ingresada con el hash almacenado
         if (password_verify($password, $fila['contrasena_usuario'])) {
            // La contraseña es correcta
            $respuesta["success"] = true;
         } else {
            // La contraseña es incorrecta
            $respuesta["error"] = "contrasena";
         }
      } else {
         // El correo no existe
         $respuesta["error"] = "correo";
      }

      // Enviamos respuesta
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
?>
