<?php

include 'conexion.php';

// Recibir los datos del formulario
$imagen_temporal = $_FILES['grupo_pic']['tmp_name'];
$nombre_imagen = $_FILES['grupo_pic']['name'];
$group_name = $_POST['grupo_nombre'];

// Procesar la imagen
if (is_uploaded_file($imagen_temporal)) {
    $imagen_datos = file_get_contents($imagen_temporal);
    $imagen_codificada = base64_encode($imagen_datos);
} else {
    echo "Error al cargar la imagen.";
    exit;
}

// Crear una instancia de la clase de conexión
$conexion = new ConexionDB();

// Realizar la consulta a la base de datos (consulta SQL directa)
$consulta = "INSERT INTO grupo (gruponame, grupopic) VALUES ('$group_name', ' $imagen_codificada');";

if ($conexion->ejecutarConsulta($consulta)) {
    header("Location: grupos.php");
} else {
    echo "Error al registrar los datos: " . $conexion->conexion->error;
}

// Cierra la conexión a la base de datos
$conexion->cerrarConexion();

?>
