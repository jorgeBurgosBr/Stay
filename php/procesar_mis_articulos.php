<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');
    $respuesta = [
        'success' => false,
        'error' => null,
        'articulos' => []
    ];
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $id_psicologo = $_SESSION['id_usuario'];
        if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $busqueda = "%{$busqueda}%"; // Prepara el término de búsqueda para LIKE
            $sql = "SELECT * FROM articulo WHERE titulo_articulo LIKE ? OR descripcion_articulo LIKE ? AND id_psicologo = ?";
            $stmnt = $conn->prepare($sql);
            $stmnt->bind_param("ssi", $busqueda, $busqueda, $id_psicologo); // 's' indica tipo string
        } else {
            $sql = "SELECT * FROM articulo WHERE id_psicologo = ?";
            $stmnt = $conn->prepare($sql);
            $stmnt->bind_param("i", $id_psicologo);
        }
        if ($stmnt->execute()) {
            $result = $stmnt->get_result();
            if ($result->num_rows > 0) {
                $respuesta['success'] = true;
                while ($row = $result->fetch_assoc()) {
                    $articulo = [
                        'id_articulo' => $row['id_articulo'],
                        'titulo_articulo' => $row['titulo_articulo'],
                        'descripcion_articulo' => $row['descripcion_articulo'],
                        'img_articulo' => $row['imagen_articulo']
                    ];
                    $respuesta['articulos'][] = $articulo;
                }
            } else {
                $respuesta['error'] = 'No se han encontrado artículos';
            }
        } else {
            $respuesta['error'] = 'Error al ejecutar la consulta';
        }
    }
    // Asegúrate de que el psicólogo ha iniciado sesión y tienes su ID
    header('Content-Type: application/json');
    echo json_encode($respuesta);
    $bd->cerrar();
}
