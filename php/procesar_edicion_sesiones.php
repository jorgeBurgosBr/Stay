<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

// Conectar a la base de datos
if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {

        $id_psicologo = $_SESSION['id_usuario'];
        $respuesta = [
            'success' => false,
            'error' => null,
        ];
        if ($_GET['select'] == 'pacientes') {
            $respuesta['pacientes'] = [];
            // Obtener nombre y apellidos de los pacientes
            $sql = "SELECT P.nombre_paciente, P.apellidos_paciente, P.id_paciente
            FROM PACIENTE P
            JOIN PACIENTE_PSICOLOGO PP ON P.id_paciente = PP.id_paciente
            WHERE PP.id_psicologo = ?";
            if ($stmt = $conn->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param("i", $id_psicologo);

                // Ejecutar
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $respuesta['success'] = true;
                        while ($row = $result->fetch_assoc()) {
                            $paciente = [
                                'id_paciente' => $row['id_paciente'],
                                'nombre' => $row['nombre_paciente'] . " " . $row['apellidos_paciente']
                            ];
                            $respuesta['pacientes'][] = $paciente;
                        }
                    } else {
                        $respuesta["error"] = "El psicólogo no tiene pacientes";
                    }
                } else {
                    $respuesta["error"] = "Error al ejecutar la consulta.";
                }
                $stmt->close();
            } else {
                $respuesta["error"] = "Error al preparar la consulta.";
            }
        } else if ($_GET['select'] == 'sesiones') {
            $respuesta['citas'] = [];
            $fecha_actual = date('Y-m-d'); // Obtiene la fecha de hoy
            // Obtener las citas de hoy en adelante
            $sql = "SELECT CITA.id_cita, CITA.fecha_cita, CITA.hora_cita, PACIENTE.nombre_paciente, PACIENTE.apellidos_paciente, PACIENTE.id_paciente
            FROM CITA 
            JOIN PACIENTE ON CITA.id_paciente = PACIENTE.id_paciente 
            WHERE CITA.id_psicologo = ? AND CITA.fecha_cita >= ?";
            if ($stmt = $conn->prepare($sql)) {
                // Vincular parámetros
                $stmt->bind_param("is", $id_psicologo, $fecha_actual);

                // Ejecutar
                if ($stmt->execute()) {
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        $respuesta['success'] = true;
                        while ($row = $result->fetch_assoc()) {
                            $cita = [
                                'id_cita' => $row['id_cita'],
                                'fecha' => $row['fecha_cita'],
                                'hora' => $row['hora_cita'],
                                'paciente' => $row['nombre_paciente'] . " " . $row['apellidos_paciente']
                            ];
                            $respuesta['citas'][] = $cita;
                        }
                    } else {
                        $respuesta["error"] = "El psicólogo no tiene citas";
                    }
                } else {
                    $respuesta["error"] = "Error al ejecutar la consulta.";
                }
                $stmt->close();
            } else {
                $respuesta["error"] = "Error al preparar la consulta.";
            }
        }
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['accion'])) {
            switch ($_POST['accion']) {
                case 'anadir':
                    $id_paciente = $_POST['id_paciente'];
                    $fecha = $_POST['fecha'];
                    $hora = $_POST['hora'];

                    $sql = "INSERT INTO CITA (id_paciente, id_psicologo, fecha_cita, hora_cita) VALUES (?, ?, ?, ?)";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("iiss", $id_paciente, $_SESSION['id_usuario'], $fecha, $hora);

                        if ($stmt->execute()) {
                            $respuesta['success'] = true;
                        } else {
                            $respuesta['error'] = 'Error al añadir la cita.';
                        }
                        $stmt->close();
                    } else {
                        $respuesta['error'] = 'Error al preparar la consulta de añadir.';
                    }
                    break;

                case 'eliminar':
                    $id_cita = $_POST['id_cita'];

                    $sql = "DELETE FROM CITA WHERE id_cita = ?";

                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("i", $id_cita);

                        if ($stmt->execute()) {
                            $respuesta['success'] = true;
                        } else {
                            $respuesta['error'] = 'Error al eliminar la cita.';
                        }
                        $stmt->close();
                    } else {
                        $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
                    }
                    break;

                default:
                    $respuesta['error'] = 'Acción no reconocida.';
                    break;
            }
        } else {
            $respuesta['error'] = 'Acción no especificada.';
        }
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }

    $bd->cerrar();
}
