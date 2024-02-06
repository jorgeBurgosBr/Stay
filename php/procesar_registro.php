<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   // echo "se ha conectado perfectamente";

   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $errores = array();
      $nombre_completo = mysqli_real_escape_string($conn, $_POST['nombre']);
      $correo = mysqli_real_escape_string($conn, $_POST['correo']);
      $password = mysqli_real_escape_string($conn, $_POST['password']);

      // Hacemos un split del nombre completo por el espacio en blanco
      $partesNombre = explode(" ", $nombre_completo);

      // Verificamos si hay al menos dos partes (nombre y apellido)
      if (count($partesNombre) >= 2) {
         // El primer elemento será el nombre
         $nombre = $partesNombre[0];

         // El resto de los elementos serán el apellido
         // Usamos la función implode para unir los elementos del array excepto el primero (el nombre)
         $apellido = implode(" ", array_slice($partesNombre, 1));
      } else {
         // Si no hay al menos dos partes, asumimos que solo hay un nombre
         $nombre = $nombre_completo;
         $apellido = "";
      }
      // Comprobar si el usuario ya existe en la base de datos
      $sql = mysqli_query($conn, "SELECT * FROM paciente WHERE correo_paciente = '$correo'");
      if (mysqli_num_rows($sql) > 0) {
         $errores['correo'] = 'El correo ya está registrado';
         // Convertir el array de errores a formato JSON y enviarlo como respuesta
         echo json_encode($errores);
      } else {
         //Insertamos los datos en la BBDD
         $sql2 = mysqli_query($conn, "INSERT INTO paciente (nombre_paciente, apellidos_paciente, correo_paciente, telefono_paciente) 
                                    VALUES ('$nombre', '$apellido', '$correo', '')");
         $sql3 = mysqli_query($conn, "INSERT INTO usuario (nombre_usuario, contrasena_usuario, tipo_usuario, id_original)
                                    VALUES ('$nombre + id_original', '$password', 'paciente', '')"); //el nombre de usuario es el nombre seguirdo del id_original
         if ($sql2 and $sql3) { //si los datos han sido insertados
            echo json_encode("exito registro");
            $sql4 = mysqli_query($conn, "SELECT * FROM paciente WHERE correo_paciente = '$correo'");
            if (mysqli_num_rows($sql4) > 0) {
               $row = mysqli_fetch_assoc($sql3);
               $_SESSION['id_paciente'] = $row['id_paciente']; //guardamos el id del paciente en una variable de sesión para usarlo en otros documentos
            }
         }
      }
   }
}
