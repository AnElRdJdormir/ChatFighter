<?php 

include('conexion.php');


class ListaDeContactos {

    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerContactos() {
        $user_id = $_SESSION['user_id'];


        // Consulta para obtener el otro contacto
        $sql = "SELECT CASE
                    WHEN user_contact1 = ? THEN user_contact2
                    WHEN user_contact2 = ? THEN user_contact1
                    ELSE NULL
                END AS otro_contacto
                FROM contacto
                WHERE user_contact1 = ? OR user_contact2 = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiii", $user_id, $user_id, $user_id, $user_id);

        $stmt->execute();
        $result = $stmt->get_result();

        $contactDetails = array();

        while ($row = $result->fetch_assoc()) {
            $contact_id = $row["otro_contacto"];

            // Consulta para obtener los detalles del usuario
            $userQuery = "SELECT user, userpic, useremail,username ,user_id, user_estado FROM usuario WHERE user_id = ?";
            $userStmt = $this->conexion->prepare($userQuery);
            $userStmt->bind_param("i", $contact_id);
            $userStmt->execute();
            $userResult = $userStmt->get_result();
            $userDetails = $userResult->fetch_assoc();
            $contactDetails[] = $userDetails;
        }

        return $contactDetails;
    }


    public function obtenerMensajes($usuario_id, $conta_id) {
        $sql = "SELECT chat_text, chat_img, usuario_id FROM chat WHERE (usuario_id = ? AND conta_id = ?) OR (usuario_id = ? AND conta_id = ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iiii", $usuario_id, $conta_id, $conta_id, $usuario_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $messages = array();
    
        while ($row = $result->fetch_assoc()) {
            $message = array(
                'text' => $row['chat_text'],
                'img' => $row['chat_img'],
                'user_id' => $row['usuario_id']
            );
            $messages[] = $message;
        }
    
        return $messages;
    }
    

    public function ObtenerContactosNoPertenecidos($user_id) {
        $sql = "SELECT u.* FROM usuario u
        WHERE u.user_id != ?
        AND u.user_id NOT IN (
          SELECT c.user_contact1
          FROM contacto c
          WHERE c.user_contact2 = ?
        )
        AND u.user_id NOT IN (
          SELECT c.user_contact2
          FROM contacto c
          WHERE c.user_contact1 = ?
        );";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("iii", $user_id, $user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }



}

// Crear una instancia de la clase ListaDeContactos
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();
$listaDeContactos = new ListaDeContactos($conexion);

// Obtener los contactos
$contactDetails = $listaDeContactos->obtenerContactos();

// Cerrar la conexión a la base de datos


?>