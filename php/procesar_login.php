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
      $sql = mysqli_query($conn, "SELECT * FROM usuario WHERE correo_usuario = '$correo'");
      if (mysqli_num_rows($sql) > 0) {
         // Comprobamos si la contraseña es correcta
         $sql2 = mysqli_query($conn, "SELECT * FROM usuario WHERE correo_usuario = '$correo' AND contrasena_usuario = '$password'");
         if (mysqli_num_rows($sql2) > 0) {
            // El correo y la contraseña son correctos
            $respuesta["success"] = true;
         } else {
            // La contraseña es incorrecta
            $respuesta["error"] = "contrasena";
         }
      } else {
         // Añadimos error correo
         $respuesta["error"] = "correo";
      }

      // Enviamos respuesta
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
