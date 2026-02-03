<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('conexion.php');

class EstadoOnline {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function ActualizarOnline($user_id) {

        $sqlUpdate = "UPDATE usuario SET user_estado = 'on' WHERE user_id = ?";  
        $stmtUpdate = $this->conexion->prepare($sqlUpdate);

        if ($stmtUpdate) {
            $stmtUpdate->bind_param("i", $user_id); // "i" indica que $user_id es un entero
            $stmtUpdate->execute();
            $stmtUpdate->close();

            header("Location: ChatUsuario.php");
            exit();
        } else {
            echo "Error en la preparación de la sentencia UPDATE: " . $this->conexion->error;
        }
    }
}

$userupdate_id = $_SESSION['user_id'];
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$actualizardatos = new EstadoOnline($conexion);

$actualizardatos->ActualizarOnline($userupdate_id);
$conexionDB->cerrarConexion();

?>
