<?php
session_start(); // Inicia una nueva sesión o reanuda la existente
require_once 'conecta.php'; // Incluye el archivo de conexión a la base de datos
$bd = new BaseDeDatos(); // Crea una instancia de la clase BaseDeDatos

if ($bd->conectar()) { // Intenta conectar con la base de datos
    $conn = $bd->getConexion(); // Obtiene el objeto de conexión a la base de datos
    $bd->seleccionarContexto('stay'); // Selecciona un contexto (o base de datos) específico
    if ($_SERVER["REQUEST_METHOD"] == 'GET') { // Verifica si el método de solicitud es GET

        // Inicializa la respuesta como un arreglo con valores predeterminados
        $respuesta = [
            "success" => false,
            "error" => null,
            "citas" => null
        ];
        // Obtiene el mes y año actuales
        $mes_actual = date('n');
        $anio_actual = date('Y');
        // Prepara la consulta SQL para obtener citas del paciente con id 1 para el mes y año actual
        $sql = "SELECT CITA.*, psicologo.nombre_psicologo
                FROM CITA
                JOIN psicologo ON CITA.id_psicologo = psicologo.id_psicologo
                WHERE MONTH(CITA.fecha_cita) = '$mes_actual' 
                AND YEAR(CITA.fecha_cita) = '$anio_actual'
                AND CITA.id_paciente = 1;
                ";
        // Ejecuta la consulta
        $result = mysqli_query($conn, $sql);
        // Verifica si se encontraron resultados
        if (mysqli_num_rows($result) > 0) {
            $respuesta["success"] = true; // Indica éxito
            while ($row = mysqli_fetch_assoc($result)) { // Itera sobre cada resultado
                // Crea un arreglo con información de cada cita
                $cita = [
                    "nombre_psicologo" => $row['nombre_psicologo'],
                    "dia" => date('d', strtotime($row['fecha_cita'])),
                    "hora" => date('H:i', strtotime($row['hora_cita']))
                ];
                $respuesta["citas"][] = $cita; // Añade la cita al arreglo de respuesta
            }
        } else {
            $respuesta["error"] = "No tienes ninguna sesión para este mes."; // Establece un mensaje de error si no hay citas
        }
        // Establece el tipo de contenido de la respuesta a JSON
        header('Content-Type: application/json');
        echo json_encode($respuesta); // Envía la respuesta en formato JSON
    }
}
?>
