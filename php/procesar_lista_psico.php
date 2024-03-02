<?php
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    $respuesta = [
        'success' => false,
        'error' => null,
        'psicologos' => []
    ];

    // Utilizando una sentencia preparada para evitar inyección SQL
    $sql = "SELECT p.id_psicologo, p.nombre_psicologo, p.apellidos_psicologo, p.correo_psicologo, pp.foto_psicologo, pp.estudios_psicologo, pp.especialidad_psicologo, pp.experiencia_psicologo
            FROM psicologo p
            INNER JOIN perfil_psicologo pp ON p.id_psicologo = pp.id_psicologo";

    // Verifica si se está utilizando el método POST
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $psicologoId = $_POST['psicologoId'];
        // Agrega la cláusula WHERE para obtener un psicólogo específico si se proporciona un ID
        $sql .= " WHERE p.id_psicologo = ?";
    }

    // Crear la sentencia preparada
    $stmt = mysqli_prepare($conn, $sql);

    // Si se proporcionó un ID, vincula el parámetro
    if (isset($psicologoId)) {
        mysqli_stmt_bind_param($stmt, "s", $psicologoId);
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Obtener todos los resultados en un array
    while ($row = mysqli_fetch_assoc($result)) {
         $respuesta['success'] = true;
        $psicologo = [
            'nombre' => $row['nombre_psicologo'],
            'id' => $row['id_psicologo'],
            'apellidos' => $row['apellidos_psicologo'],
            'correo' => $row['correo_psicologo'],
            'photo' => $row['foto_psicologo'],
            'estudios' => $row['estudios_psicologo'],
            'experiencia' => $row['experiencia_psicologo'],
            'especialidad' => $row['especialidad_psicologo']
        ];

        $respuesta['psicologos'][] = $psicologo;
    } 

    header('Content-Type: application/json');
    echo json_encode($respuesta);
}
?>
