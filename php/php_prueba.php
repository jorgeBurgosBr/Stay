<?php
session_start();
require_once 'conecta.php';
$bd = new BaseDeDatos();

if ($bd->conectar()) {
    $conn = $bd->getConexion();
    $bd->seleccionarContexto('stay');
    // Si el archivo ha sido añadido, creamos nueva fila en tabla articulos
    $sql = "INSERT INTO articulo (id_psicologo, titulo_articulo, descripcion_articulo, imagen_articulo) VALUES (?,?,?,?)";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("isss", $id_psicologo, 'Artículo de prueba', 'Descripción de prueba al añadir un artículo...', 'http://localhost/stay/img/articulos/articulo_6.png');

        if ($stmt->execute()) {
            $respuesta['success'] = true;
        } else {
            $respuesta['error'] = 'Error al eliminar el artículo.';
        }
        $stmt->close();
    } else {
        $respuesta['error'] = 'Error al preparar la consulta de eliminar.';
    }
} else {
    $respuesta['error'] = 'Error al mover el archivo';
}
