<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('conexion.php');



class Encripcion {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function encriptarcontra($pass, $user_id) {
        $sql = "UPDATE usuario
                SET userpassword = '$pass'
                WHERE user_id = $user_id;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $_SESSION['userpassword'] = $pass;
    }
}

$user_id = $_SESSION['user_id'];
$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$encod = new Encripcion($conexion);

// Función para encriptar la contraseña usando base64
function encryptPassword($password) {
    return base64_encode($password);
}

// Función para desencriptar la contraseña usando base64
function decryptPassword($encodedPassword) {
    return base64_decode($encodedPassword);
}

// Inicializar el mensaje como vacío
$message = '';
$copiedPassword = isset($_SESSION['userpassword']) ? $_SESSION['userpassword'] : ''; // Crear una copia de la contraseña de la sesión

// Verificar si se hizo clic en el botón de encriptar
if (isset($_POST['encrypt'])) {
    $copiedPassword = encryptPassword($copiedPassword); // Encriptar la copia
    $message = "Contraseña encriptada con éxito: " . $copiedPassword;
    $encod->encriptarcontra($copiedPassword, $user_id);
}

// Verificar si se hizo clic en el botón de desencriptar
if (isset($_POST['decrypt'])) {
    // Verificar si la cadena ya está decodificada
    if (base64_encode(base64_decode($copiedPassword, true)) === $copiedPassword) {
        $copiedPassword = decryptPassword($copiedPassword); // Desencriptar la copia
        $message = "Contraseña desencriptada con éxito: " . $copiedPassword;
        $encod->encriptarcontra($copiedPassword, $user_id);
    } else {
        $message = "Contraseña desencriptada con éxito: " . $copiedPassword;
        $encod->encriptarcontra($copiedPassword, $user_id);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CHAT FIGHTERS || Chats</title>
        <link rel="stylesheet" href="CSS/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/profilestyle.css">
        <script src="JS/bootstrap.min.js"></script>
    </head>
    
    <body>
        <div id="IDChatU">
            <div id="PanelIzq">
                <div style="padding: 10px">
                <img id="FotoIcon" src="Images\POI\Icono.png">
                <?php  
                echo '';
                echo '<img id="FotoPerfil" src="data:image/jpeg;base64,' . $_SESSION['userpic'] . '" class="profile-pic">';
                echo '<br>';
                echo 'Nombre de Usuario: '.$_SESSION['user'].'';
                echo '<br>';
                echo 'Correo: '.$_SESSION['useremail'].'';
                echo '<br>';
                echo '<button class="BotonEdit"><a href="profile.php">Editar Usuario<a></button>';
                ?>  
                </div>
            </div>

            <div id="PanelDer">
                <div id="Encabezado">
                    <ul class="navbar-nav" id="navGrid" style="list-style-type: none; padding: 0;">
                        <li class="nav-item">
                            <a class="nav-link" href="ChatUsuario.php">Inicio</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="grupos.php">Grupos</a>
                        </li>
                        
                        <li class="nav-item">
                        <a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
                
                
                <div id="idRegister" class="form-box form-value container">
                <br>

                    <p><strong>Correo Electrónico:</strong> <?php echo $_SESSION['useremail'];?></p>

                    <br>
                    <p><strong>Contraseña:</strong> <?php echo $copiedPassword;?></p>
                    <br>

                    <form method="post" action="">
                        <button class="btn btn-danger" type="submit" name="encrypt">Encriptar Contraseña</button>
                        <br>
                        <br>
                        <button class="btn btn-primary" type="submit" name="decrypt">Desencriptar Contraseña</button>
                    </form>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success mt-3" role="alert">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
