<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        $mes_actual = $_POST['mes'];
        $anio_actual = $_POST['anio'];
        $id_paciente = $_SESSION['id_paciente'];

        $respuesta = [
            "success" => false,
            "error" => null,
            "citas" => null
        ];

        $sql = "SELECT CITA.*, psicologo.nombre_psicologo
                FROM CITA
                JOIN psicologo ON CITA.id_psicologo = psicologo.id_psicologo
                WHERE MONTH(CITA.fecha_cita) = '$mes_actual' 
                AND YEAR(CITA.fecha_cita) = '$anio_actual'
                AND CITA.id_paciente = '$id_paciente';
                ";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $respuesta["success"] = true;
            while ($row = mysqli_fetch_assoc($result)) {
                $cita = [
                    "nombre_psicologo" => $row['nombre_psicologo'],
                    "dia" => date('d', strtotime($row['fecha_cita'])),
                    "hora" => date('H:i', strtotime($row['hora_cita']))
                ];
                $respuesta["citas"][] = $cita;
            }
        } else {
            $respuesta["error"] = "No tienes ninguna sesión para este mes.";
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    $bd->cerrar();
}
?>
