<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();
$id_psicologo = $_SESSION["id_usuario"];
// Conectar a la base de datos
if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');

   // Respuesta predeterminada
   $respuesta = [];

   // Sentencia preparada
   $sql = "SELECT p.*, pp.*, np.*
            FROM 
                PACIENTE_PSICOLOGO ps
            JOIN 
                PACIENTE p ON ps.id_paciente = p.id_paciente
            JOIN 
                PERFIL_PACIENTE pp ON pp.id_paciente = p.id_paciente
            JOIN 
                NOTAS_PACIENTE np ON np.id_paciente = p.id_paciente
            WHERE 
                ps.id_psicologo = ?";

   // Preparar la sentencia
   if ($stmt = mysqli_prepare($conn, $sql)) {
      // Vincular parámetros
      mysqli_stmt_bind_param($stmt, "i", $id_psicologo);

      // Ejecutar la consulta
      if (mysqli_stmt_execute($stmt)) {
         // Obtener resultados
         $result = mysqli_stmt_get_result($stmt);

         if (mysqli_num_rows($result) > 0) {
            // Iterar sobre los resultados y guardar cada fila en el array $respuesta
            $respuesta['success'] = true;
            while ($row = mysqli_fetch_assoc($result)) {
               //pasar la fecha de nacimiento a años
               $fecha_nacimiento_bd = $row['fecha_nac_paciente'];
               $fecha_nacimiento_dt = new DateTime($fecha_nacimiento_bd);
               $fecha_actual = new DateTime();
               $diferencia = $fecha_actual->diff($fecha_nacimiento_dt);
               $edad = $diferencia->y;

               //cambiar a masculino o femenino
               $genero = $row['sexo_paciente'];
               if (
                  $genero === 'masculino'
               ) {
                  $genero_modificado = 'hombre';
               } elseif (
                  $genero === 'femenino'
               ) {
                  $genero_modificado = 'mujer';
               } else {
                  // Si el género no es ni masculino ni femenino, podrías manejarlo de otra manera
                  $genero_modificado = 'desconocido';
               }
               $fila = [
                  'nombre' => $row['nombre_paciente'],
                  'apellidos' => $row['apellidos_paciente'],
                  'edad' =>  $edad,
                  'genero' => $genero_modificado,
                  'img' => $row['foto_paciente'],
                  'bio' => $row['bio'],
               ];
               // Añadir la fila al array de resultados
               $respuesta[] = $fila;
            }
            // Enviar la respuesta como JSON
            header('Content-Type: application/json');
            echo json_encode($respuesta);
         }
      } else {
         // Error en la ejecución de la consulta
         $respuesta['error'] = 'Error en la ejecución de la consulta: ' . mysqli_stmt_error($stmt);
         echo json_encode($respuesta);
      }
      // Cerrar la sentencia
      mysqli_stmt_close($stmt);
   } else {
      // Error en la preparación de la consulta SQL
      $respuesta['error'] = 'Error en la preparación de la consulta SQL: ' . mysqli_error($conn);
      echo json_encode($respuesta);
   }
} else {
   // Error en la conexión a la base de datos
   $respuesta['error'] = 'Error en la conexión a la base de datos: ' . mysqli_connect_error();
   echo json_encode($respuesta);
}
