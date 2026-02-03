<?php
// Incluye el archivo de conexión
include 'conexion.php';

// Recibir los datos del formulario
$imagen_temporal = $_FILES['idRegisterAvatarBtn']['tmp_name'];
$nombre_imagen = $_FILES['idRegisterAvatarBtn']['name'];

$reg_mail = $_POST['txtEmail'];
$reg_username = $_POST['txtUsername'];
$reg_password = $_POST['txtPassword'];
$reg_name = $_POST['txtFullname'];
$reg_birth = $_POST['reg_birth'];

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
$consulta = "INSERT INTO usuario (user, useremail, userpassword, username, userbirth, userpic) VALUES ('$reg_username', '$reg_mail', '$reg_password', '$reg_name', '$reg_birth', '$imagen_codificada')";

if ($conexion->ejecutarConsulta($consulta)) {
    header("Location: Login.html");
} else {
    echo "Error al registrar los datos: " . $conexion->conexion->error;
}

// Cierra la conexión a la base de datos
$conexion->cerrarConexion();

?>