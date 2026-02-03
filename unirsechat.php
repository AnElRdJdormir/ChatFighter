<?php
include('conexion.php');
session_start();

class ChatJoin {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function unirsechat($user_id, $cont_id) {
            $sql = "INSERT INTO contacto (user_contact1, user_contact2) VALUES (?, ?);";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $user_id, $cont_id);
            $stmt->execute();    
    }
}

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

if (isset($_GET['cont_id'])) {
    $cont_id = $_GET['cont_id'];
    $user_id = $_SESSION['user_id'];

    $contjoin = new ChatJoin($conexion);
    $contjoin->unirsechat($user_id, $cont_id);

    header("Location: ChatUsuario.php");
}
?>
