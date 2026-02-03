<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica si el usuario está conectado
if (isset($_SESSION['user_id'])) {
    include('conexion.php');

    // Instancia la conexión
    $conexionDB = new ConexionDB();
    $conexion = $conexionDB->getConexion();

    $user_id = $_SESSION['user_id'];

    // Actualiza el estado del usuario a offline
    $sql = "UPDATE usuario SET user_estado = 'offline' WHERE user_id = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->close();
    } else {
        die("Error al preparar la consulta: " . $conexion->error);
    }

    // Cierra la conexión
    $conexionDB->cerrarConexion();
}

// Destruye la sesión
session_unset();
session_destroy();

// Redirige al usuario al inicio de sesión
header("Location: Login.html");
exit();
?>
