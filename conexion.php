<?php 
class ConexionDB {
    private $host = "localhost";
    private $usuario = "root";
    private $contrasena = "Contra";
    private $base_datos = "prograinternet";
    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->contrasena, $this->base_datos);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function getConexion() {
        return $this->conexion;
    }
    
    public function ejecutarConsulta($consulta) {
        $resultado = $this->conexion->query($consulta);
        return $resultado;
    }

    public function cerrarConexion() {
        $this->conexion->close();
    }
}

?>