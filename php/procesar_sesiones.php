<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER["REQUEST_METHOD"] == 'POST') {


        // Asume que los datos vienen como 'fechaInicio' y 'fechaFin'
        $fechaInicio = $_POST['fechaInicio'];
        $fechaFin = $_POST['fechaFin'];
        $id_paciente = $_SESSION['id_usuario'];

        $respuesta = [
            "success" => false,
            "error" => null,
            "citas" => []
        ];

        $sql = "SELECT CITA.*, psicologo.nombre_psicologo, psicologo.apellidos_psicologo
                    FROM CITA
                    JOIN psicologo ON CITA.id_psicologo = psicologo.id_psicologo
                    WHERE CITA.fecha_cita BETWEEN ? AND ?
                    AND CITA.id_paciente = ?
                    ORDER BY CITA.fecha_cita;";

        // Preparar la sentencia
        if ($stmt = $conn->prepare($sql)) {
            // Vincular parámetros
            $stmt->bind_param("ssi", $fechaInicio, $fechaFin, $id_paciente);

            // Ejecutar
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $respuesta["success"] = true;
                    while ($row = $result->fetch_assoc()) {
                        $cita = [
                            "nombre_psicologo" => $row['nombre_psicologo'],
                            "apellidos_psicologo" => $row['apellidos_psicologo'],
                            "fecha" => date('Y-m-d', strtotime($row['fecha_cita'])),
                            "hora" => date('H:i', strtotime($row['hora_cita']))
                        ];
                        $respuesta["citas"][] = $cita;
                    }
                } else {
                    $respuesta["error"] = "No tienes ninguna sesión para este rango de fechas.";
                }
            } else {
                $respuesta["error"] = "Error al ejecutar la consulta.";
            }
            $stmt->close();
        } else {
            $respuesta["error"] = "Error al preparar la consulta.";
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    $bd->cerrar();
}
