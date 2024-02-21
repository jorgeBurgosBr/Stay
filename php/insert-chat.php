<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
// if (isset($_SESSION['id_usuario'])) {
$outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$message = mysqli_real_escape_string($conn, $_POST['message']);
$respuesta;

if (!empty($message)) {
   $all = "INSERT INTO mensajes (msg_entrada_id, msg_salida_id, msg)
                        VALUES ($incoming_id, $outgoing_id, '$message')";
   $sql = mysqli_query($conn, $all);
   $respuesta["success"] = "algo distinto";
} else {
   $respuesta["error"] = "correo";
}
echo json_encode($respuesta);
// } else {
   // header("../index.php");
// }
