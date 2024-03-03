<?php
require_once 'conecta.php';

$bd = new BaseDeDatos();
if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $respuesta = [
            'success' => false,
            'error' => null,
            'articulos' => []
        ];

        if (isset($_GET['busqueda']) && !empty($_GET['busqueda'])) {
            $busqueda = $_GET['busqueda'];
            $busqueda = "%{$busqueda}%"; // Prepara el término de búsqueda para LIKE
            $sql = "SELECT * FROM articulo WHERE titulo_articulo LIKE ? OR descripcion_articulo LIKE ?";
            $stmnt = $conn->prepare($sql);
            $stmnt->bind_param("ss", $busqueda, $busqueda); // 's' indica tipo string
        } else {
            $sql = "SELECT * FROM articulo";
            $stmnt = $conn->prepare($sql);
        }

        $stmnt->execute();
        $result = $stmnt->get_result();
        if ($result->num_rows > 0) {
            $respuesta['success'] = true;
            while ($row = $result->fetch_assoc()) {
                $articulo = [
                    'id_articulo' => $row['id_articulo'],
                    'id_psicologo' => $row['id_psicologo'],
                    'titulo_articulo' => $row['titulo_articulo'],
                    'descripcion_articulo' => $row['descripcion_articulo'],
                    'img_articulo' => $row['imagen_articulo']
                ];
                $respuesta['articulos'][] = $articulo;
            }
        } else {
            $respuesta['error'] = 'No se han encontrado artículos';
        }

        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $respuesta = [
            'success' => false,
            'error' => null,
            'url' => null
        ];

        $sql = "SELECT contenido_articulo FROM entrada_articulo WHERE id_articulo = ?";
        $stmnt = $conn->prepare($sql);
        $stmnt->bind_param("i", $_POST['id_articulo']);
        $stmnt->execute();
        $result = $stmnt->get_result();
        if ($result->num_rows > 0) {
            $respuesta['success'] = true;
            $row = $result->fetch_assoc();
            $respuesta['url'] = $row['contenido_articulo'];
        } else {
            $respuesta['error'] = 'No se han encontrado entradas de articulo';
        }
        header('Content-Type: application/json');
        echo json_encode($respuesta);
    }
    $bd->cerrar();
}
