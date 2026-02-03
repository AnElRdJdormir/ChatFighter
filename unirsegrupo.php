<?php
include('conexion.php');
session_start();

class Grupo {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarPertenencia($user_id, $grupo_id) {
        $sql = "SELECT COUNT(*) AS count FROM miembro WHERE user_id = ? AND grupo_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ii", $user_id, $grupo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['count'] > 0;
    }

    public function unirseAGrupo($user_id, $grupo_id) {
        if (!$this->verificarPertenencia($user_id, $grupo_id)) {
            $sql = "INSERT INTO miembro (user_id, grupo_id) VALUES (?, ?)";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("ii", $user_id, $grupo_id);
            $stmt->execute();
        }
    }
}

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

if (isset($_GET['grupo_id'])) {
    $grupo_id = $_GET['grupo_id'];
    $user_id = $_SESSION['user_id'];

    $grupo = new Grupo($conexion);
    $grupo->unirseAGrupo($user_id, $grupo_id);

    header("Location: grupos.php");
}
?>