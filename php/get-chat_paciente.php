<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
// if (isset($_SESSION['unique_id'])) {
$outgoing_id = mysqli_real_escape_string($conn, $_POST['outgoing_id']);
$incoming_id = mysqli_real_escape_string($conn, $_POST['incoming_id']);
$output = "";

$sql = "SELECT * FROM mensajes 
   LEFT JOIN paciente ON paciente.id_paciente = mensajes.msg_salida_id
   WHERE (msg_salida_id = {$outgoing_id} AND msg_entrada_id = {$incoming_id})
            OR (msg_salida_id = {$incoming_id} AND msg_entrada_id = {$outgoing_id}) ORDER BY msg_id";
$query = mysqli_query($conn, $sql);
if (mysqli_num_rows($query) > 0) {
   while ($row = mysqli_fetch_assoc($query)) {
      if ($row['msg_salida_id'] === $outgoing_id) { // if this is equal to then he is a msg sender
         $output .= '<div class="chat outgoing">
                           <div class="details">
                              <p>' . $row['msg'] . '</p>
                           </div>
                        </div>';
      } else { // he is a msg receiver
         $output .= '<div class="chat incoming">
                           <div class="details">
                              <p>' . $row['msg'] . '</p>
                           </div>
                        </div>';
      }
   }
   echo $output;
}
// } else {
//    header("../login.php");
// }
