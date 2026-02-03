<?php
include('conexion.php');

class VerificacionLogin {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function verificarCredenciales($correo, $contrasena, $contracod) {
        $sql = "SELECT user_id, user, useremail, userpic, userpassword, userbirth 
        FROM usuario 
        WHERE useremail = ? AND (userpassword = ? OR userpassword = ?);";
        $stmt = $this->conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sss", $correo, $contrasena, $contracod); // Sin comillas simples
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                // Iniciar la sesión y guardar el ID del usuario en la sesión
                session_start();
                $row = $result->fetch_assoc();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['user'] = $row['user'];
                $_SESSION['useremail'] = $row['useremail'];
                $_SESSION['userpic'] = $row['userpic'];
                $_SESSION['userpassword'] = $row['userpassword'];
                $_SESSION['userbirth'] = $row['userbirth'];
                // Credenciales correctas, redirigir a otra página
                $response = array('status' => 'success', 'message' => 'Inicio de sesión exitoso');
                echo json_encode($response);
                exit();

            } else {
                // Credenciales incorrectas, mostrar un mensaje de error
                $response = array('status' => 'error', 'message' => 'Credenciales incorrectas. Por favor, inténtalo de nuevo.');
                echo json_encode($response);
            }

            $stmt->close();
        } else {
            echo "Error en la preparación de la sentencia: " . $this->conexion->error;
        }
    }

        private function actualizarEstadoUsuario($correo, $contrasena) {
        $sqlUpdate = "UPDATE usuario SET user_estado = 'online' WHERE useremail = ? AND userpassword = ?;";
        $stmtUpdate = $this->conexion->prepare($sqlUpdate);

        if ($stmtUpdate) {
            $stmtUpdate->bind_param("ss", $correo, $contrasena);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        } else {
            echo "Error en la preparación de la sentencia UPDATE: " . $this->conexion->error;
        }
    }
}


// Crear una instancia de la clase VerificacionLogin
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();
$verificacionLogin = new VerificacionLogin($conexion);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuarioVer = $_POST["log_mail"];
    $contrasenaVer = $_POST["log_password"];
    $contrasenaCod = base64_encode($_POST["log_password"]);
    // Llamar al método verificarCredenciales con los datos del formulario
    $verificacionLogin->verificarCredenciales($usuarioVer, $contrasenaVer, $contrasenaCod);
}

// Cerrar la conexión a la base de datos
$conexionDB->cerrarConexion();

?>


