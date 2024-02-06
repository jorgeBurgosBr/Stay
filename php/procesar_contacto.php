<?php
session_start();
include_once 'conecta.php';

// Verifica si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Recibe los datos del formulario
   $nombre = $_POST['nombre'];
   $telefono = $_POST['telefono'];
   $correo = $_POST['correo'];
   $comentario = $_POST['comentario'];

   // Dirección de correo a la que se enviará el formulario
   $destinatario = 'stay@gmail.com';

   // Asunto del correo
   $asunto = 'Nuevo mensaje del formulario de contacto';

   // Cuerpo del correo
   $mensaje = "Nombre: $nombre\n";
   $mensaje .= "Teléfono: $telefono\n";
   $mensaje .= "Correo electrónico: $correo\n";
   $mensaje .= "Comentario:\n$comentario\n";

   // Cabeceras del correo
   $cabeceras = 'From: ' . $correo . "\r\n" .
      'Reply-To: ' . $correo . "\r\n" .
      'X-Mailer: PHP/' . phpversion();

   // Envía el correo
   if (mail($destinatario, $asunto, $mensaje, $cabeceras)) {
      echo 'El mensaje ha sido enviado correctamente.';
   } else {
      echo 'Error al enviar el mensaje.';
   }
   header("Location: ../index.php");
}
