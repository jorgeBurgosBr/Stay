<?php
session_start();
// $outgoing_id = $_SESSION['unique_id'];
$output = "";
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$outgoing_id = 2;
$sql = mysqli_query($conn, "SELECT p.*
                           FROM PACIENTE p
                           JOIN PACIENTE_PSICOLOGO pp ON p.id_paciente = pp.id_paciente
                           WHERE pp.id_psicologo = $outgoing_id
                           AND (p.nombre_paciente LIKE '%{$searchTerm}%' OR p.apellidos_paciente LIKE '%{$searchTerm}%')");

if (mysqli_num_rows($sql) > 0) {
   include "data.php";
} else {
   $output .= "No user found relatd to your search term";
}
echo $output;
