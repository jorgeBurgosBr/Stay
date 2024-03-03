<?php
session_start();
$outgoing_id = $_SESSION['id_paciente'];
$output = "";
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
$searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
$sql = mysqli_query($conn, "SELECT p.*, pep.*
                           FROM PACIENTE p
                           JOIN 
                              PERFIL_PACIENTE pep ON p.id_paciente = pep.id_paciente
                           JOIN PACIENTE_PSICOLOGO pp ON p.id_paciente = pp.id_paciente
                           WHERE pp.id_psicologo = $outgoing_id
                           AND (p.nombre_paciente LIKE '%{$searchTerm}%' OR p.apellidos_paciente LIKE '%{$searchTerm}%')");

if (mysqli_num_rows($sql) > 0) {
   include "data.php";
} else {
   $output .= "ningún usuario encontrado con ese nombre";
}
echo $output;
