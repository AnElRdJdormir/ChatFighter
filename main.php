<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $message = $_POST['mensaje']; 
    $conta_id = $_POST['selected_user_id']; 
    $usuario_id = $_SESSION['user_id'];
    $edit_temporal = $_FILES['edit_imagen']['tmp_name'];
    $edit_imagen = $_FILES['edit_imagen']['name'];

        // Procesar la imagen
        if (is_uploaded_file($edit_temporal)) {
            $imagen_datos = file_get_contents($edit_temporal);
            $imagen_codificada = base64_encode($imagen_datos);
        } 
        
    include 'conexion.php'; 

    $conexion = new ConexionDB();

    $message = $conexion->getConexion()->real_escape_string($message);

    $consulta = "INSERT INTO chat (chat_text, conta_id, usuario_id, chat_img) VALUES ('$message', '$conta_id', '$usuario_id','$imagen_codificada')";

    if ($conexion->ejecutarConsulta($consulta)) {

        echo '<script>window.location.href = "Chat.php?user_id=' .$_POST['selected_user_id']. '";</script>';

    } else {

        echo "Error al insertar el mensaje: " . $conexion->getConexion()->error;
    }

    // Cierra la conexión a la base de datos
    $conexion->cerrarConexion();
} else {   
    header("Location: ChatUsuario.php");
}
?>