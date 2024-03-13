<?php
session_start();
require_once 'conecta.php';

$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
   $conn = $bd->getConexion();
   $bd->seleccionarContexto('stay');

   // Respuesta predeterminada
   $respuesta = [];

   // Verificar si se ha enviado algún dato a través del formulario
   if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Verificar si el comentario ha sido enviado y no está vacío
      if (isset($_POST['comentario']) && !empty($_POST['comentario'])) {
         // Obtener los datos del formulario
         $comentario = $_POST['comentario'];
         $id_publicacion = $_POST['id_publicacion']; // ID de la publicación relacionada al comentario
         $id_usuario = $_SESSION['id_usuario']; // ID del usuario que está realizando el comentario

         // Insertar el comentario en la base de datos
         $sql = "INSERT INTO COMENTARIOS_FORO (id_publicacion, comentario, fecha, id_usuario) VALUES (?, ?, NOW(), ?)";
         $stmt = $conn->prepare($sql);
         $stmt->bind_param("isi", $id_publicacion, $comentario, $id_usuario);

         if ($stmt->execute()) {
            // Si la inserción fue exitosa, envía una respuesta de éxito al cliente
            echo json_encode(array("success" => true, "message" => "Comentario agregado correctamente"));
         } else {
            // Si hubo un error en la inserción, envía un mensaje de error al cliente
            echo json_encode(array("success" => false, "message" => "Error al agregar el comentario"));
         }

         // Cerrar la conexión y liberar los recursos
         $stmt->close();
      } else {
         // Si el comentario está vacío, enviar un mensaje de error
         echo json_encode(array("success" => false, "message" => "El comentario está vacío"));
      }
   } else {
      // Si no se ha enviado ningún dato a través del formulario, enviar un mensaje de error
      echo json_encode(array("success" => false, "message" => "No se recibieron datos"));
   }
}
