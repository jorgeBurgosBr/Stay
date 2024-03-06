<?php
session_start();
require_once 'conecta.php'; // Asumo que este archivo contiene la clase BaseDeDatos y se encarga de la conexión

$bd = new BaseDeDatos();
// $id_psicologo = $_SESSION["id_usuario"];

// Conectar a la base de datos
if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');

   $respuesta = [
      'success' => false,
      'error' => "no ha pasado por dentro"
   ];

   // Verificar si se recibieron los datos del formulario mediante POST
   $data = json_decode(file_get_contents("php://input"), true);
   if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($data["id"]) && isset($data["bio"])) {
      $id = $data["id"];
      $bio = $data["bio"];

      // Preparar la consulta SQL para actualizar la bio del paciente
      $sql = "INSERT INTO NOTAS_PACIENTE (id_paciente, bio) VALUES (?, ?) ON DUPLICATE KEY UPDATE bio = VALUES(bio)";

      // Preparar la declaración
      if ($stmt = $conn->prepare($sql)) {
         // Vincular variables a la declaración preparada como parámetros
         $stmt->bind_param("is", $id, $bio);


         // Ejecutar la declaración
         if ($stmt->execute()) {
            // Si la consulta se ejecutó con éxito
            $respuesta['success'] = true;
         } else {
            // Si ocurrió un error durante la ejecución de la consulta
            $respuesta['error'] = "Error al actualizar la bio: " . $stmt->error;
         }

         // Cerrar la declaración preparada
         $stmt->close();
      } else {
         // Si ocurrió un error al preparar la consulta
         $respuesta['error'] = "Error al preparar la consulta: " . $conn->error;
      }
   }
   // Enviar la respuesta como JSON
   header('Content-Type: application/json');
   echo json_encode($respuesta);
}
