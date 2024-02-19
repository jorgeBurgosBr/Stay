<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   // echo "se ha conectado perfectamente";

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $respuesta = [
         'success' => false,
         'error' => null
      ];
      $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
      $apellidos = mysqli_real_escape_string($conn, $_POST['apellidos']);
      $correo = mysqli_real_escape_string($conn, $_POST['correo']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);

      // Comprobar si el usuario ya existe en la base de datos
      $sql = mysqli_query($conn, "SELECT * FROM paciente WHERE correo_paciente = '$correo'");
      if (mysqli_num_rows($sql) > 0) {
         $respuesta['success'] = false;
         $respuesta['error'] = 'El correo ya está registrado';
      } else {
         //Insertamos los datos en la BBDD
         $sql2 = mysqli_query($conn, "INSERT INTO paciente (nombre_paciente, apellidos_paciente, correo_paciente, telefono_paciente) 
                                    VALUES ('$nombre', '$apellidos', '$correo', '')");
         $sql3 = mysqli_query($conn, "SELECT id_paciente FROM paciente WHERE correo_paciente = '$correo'");

         // Recojo el id del paciente
         $row = mysqli_fetch_assoc($sql3);
         $id_original = $row['id_paciente'];

         $sql4 = mysqli_query($conn, "INSERT INTO usuario (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                                    VALUES ('$correo', '$password', 'paciente', '$id_original')");
         if ($sql4) { //si los datos han sido insertados
            $respuesta['success'] = true;
            $_SESSION['id_paciente'] = $id_original;
         }
      }
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
