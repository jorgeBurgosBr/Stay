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

      $contrasena_hash = password_hash($password, PASSWORD_DEFAULT);

      // Comprobar si el usuario ya existe en la base de datos
      $sql = mysqli_query($conn, "SELECT * FROM paciente WHERE correo_paciente = '$correo'");
      if (mysqli_num_rows($sql) > 0) {
         $respuesta['success'] = false;
         $respuesta['error'] = 'El correo ya está registrado';
      } else {
         //Insertamos los datos en la BBDD
         $sql2 = mysqli_query($conn, "INSERT INTO paciente (nombre_paciente, apellidos_paciente, correo_paciente) 
                                    VALUES ('$nombre', '$apellidos', '$correo')");
         $sql3 = mysqli_query($conn, "SELECT id_paciente FROM paciente WHERE correo_paciente = '$correo'");

         // Recojo el id del paciente
         $row = mysqli_fetch_assoc($sql3);
         $id_original = $row['id_paciente'];

         $sql4 = mysqli_query($conn, "INSERT INTO usuario (correo_usuario, contrasena_usuario, tipo_usuario, id_original)
                                    VALUES ('$correo', '$contrasena_hash', 'paciente', '$id_original')");

         // Insertar en la tabla perfil_paciente con valores predeterminados
         $sql5 = mysqli_query($conn, "INSERT INTO perfil_paciente (id_paciente, fecha_nac_paciente, sexo_paciente, pareja_sino_paciente, hijos_paciente, trabajo_paciente, estudios_paciente, hobbies_paciente, expectativasypreocupaciones_paciente, foto_paciente) 
         VALUES ('$id_original', NULL, 'otro', NULL, NULL, NULL, NULL, NULL, NULL, './img/paciente/default.png')");

         $sql6 = mysqli_query($conn, "INSERT INTO notas_paciente(id_paciente, bio, notas) VALUES ('$id_original', NULL, NULL)");

         if ($sql4 && $sql5 && $sql6) { //si los datos han sido insertados
            $respuesta['success'] = true;
            $_SESSION['id_usuario'] = $id_original;
         }
      }
      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}
