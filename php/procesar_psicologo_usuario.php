<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');
   // echo "se ha conectado perfectamente";

   if ($_SERVER["REQUEST_METHOD"] == "GET") {
      $respuesta = [
         'success' => false,
         'error' => null
      ];

      $id_paciente = $_SESSION['id_paciente'];

      // Realizar la consulta para obtener el nombre y el correo del paciente
      $sql = mysqli_query($conn, "SELECT
      psicologo.nombre_psicologo,
      psicologo.apellidos_psicologo,
      psicologo.correo_psicologo,
      psicologo.tel_psicologo,
      perfil_psicologo.fecha_nac_psicologo,
      perfil_psicologo.sobre_mi,
      perfil_psicologo.especialidad_psicologo,
      perfil_psicologo.experiencia_psicologo,
      perfil_psicologo.estudios_psicologo,
      perfil_psicologo.hobbies_psicologo,
      perfil_psicologo.foto_psicologo
  FROM
      PSICOLOGO psicologo
  INNER JOIN
      PERFIL_PSICOLOGO perfil_psicologo ON psicologo.id_psicologo = perfil_psicologo.id_psicologo
  INNER JOIN
      PACIENTE_PSICOLOGO paciente_psicologo ON psicologo.id_psicologo = paciente_psicologo.id_psicologo
  WHERE
      paciente_psicologo.id_paciente = '$id_paciente'");
      $row = mysqli_fetch_assoc($sql);

      if ($row) {
         $respuesta['success'] = true;
         $respuesta['nombre'] = $row['nombre_psicologo'];
         $respuesta['apellidos'] = $row['apellidos_psicologo'];
         $respuesta['correo'] = $row['correo_psicologo'];
         $respuesta['telefono'] = $row['tel_psicologo'];
         $respuesta['fecha'] = $row['fecha_nac_psicologo'];
         $respuesta['sobre_mi'] = $row['sobre_mi'];
         $respuesta['especialidad'] = $row['especialidad_psicologo'];
         $respuesta['experiencia'] = $row['experiencia_psicologo'];
         $respuesta['estudios'] = $row['estudios_psicologo'];
         $respuesta['hobbies'] = $row['hobbies_psicologo'];
         $respuesta['foto_psico'] = $row['foto_psicologo'];
      } else {
         $respuesta['error'] = 'Error al obtener la información del paciente';
      }

      header('Content-Type: application/json');
      echo json_encode($respuesta);
   }
}