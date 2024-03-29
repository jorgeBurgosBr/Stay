<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();
$bd->conectar();
$conn = $bd->getConexion();
$bd->seleccionarContexto('stay');
$outgoing_id = $_SESSION['id_usuario'];
$sql = mysqli_query($conn, "SELECT p.*, pep.*
                           FROM PACIENTE p
                           JOIN 
                              PERFIL_PACIENTE pep ON p.id_paciente = pep.id_paciente
                           JOIN PACIENTE_PSICOLOGO pp ON p.id_paciente = pp.id_paciente
                           WHERE pp.id_psicologo = $outgoing_id;");
$output = "";
if (mysqli_num_rows($sql) == 0) {
   $output .= "No hay pacientes disponibles para hablar";
} elseif (mysqli_num_rows($sql) > 0) {
   include "data.php";
}
echo $output;
