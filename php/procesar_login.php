<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   if ($_SERVER["REQUEST_METHOD"] == 'POST') {
      $errores = array();
      $correo = mysqli_real_escape_string($conn, $_POST['correo']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);
      // Comprobar si el usuario existe en la base de datos
      $sql = mysqli_query($conn, "SELECT * FROM paciente p INNER JOIN usuario u ON p.id_paciente = u.id_usuario WHERE p.correo_paciente = '$correo' AND u.contrasena_usuario = '$password'");
      if (mysqli_num_rows($sql) > 0) {
         echo json_encode("exito login");
      } else {
         $sql2 = mysqli_query($conn, "SELECT * FROM paciente p INNER JOIN usuario u ON p.id_paciente = u.id_usuario WHERE p.correo_paciente = '$correo'");
         if (mysqli_num_rows($sql2) > 0) {
            //El correo existe
            $sql3 = mysqli_query($conn, "SELECT * FROM paciente p INNER JOIN usuario u ON p.id_paciente = u.id_usuario WHERE u.contrasena_usuario = '$password'");
            if (mysqli_num_rows($sql3) > 0) {
               //la contraseña es correca y por lo tanto ya tendría que haber iniciado sesión
            } else {
               //guardamos en el array de erroes que la contraseña es incorrecta
               $errores['password'] = 'La contraseña es incorrecta';
               echo json_encode($errores);
            }
         } else {
            //guardarmos en el array de errores que el correo no existe
            $errores['correo'] = 'El correo no existe';
            echo json_encode($errores);
         }
      }
   }
}
