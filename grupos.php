<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('conexion.php');

class Grupo {
    private $conexion;

    public function __construct($conexion) {
        $this->conexion = $conexion;
    }

    public function obtenerGruposDeUsuario($user_id) {
        $sql = "SELECT grupo.grupo_id, grupo.gruponame, grupo.grupopic
                FROM grupo
                JOIN miembro ON grupo.grupo_id = miembro.grupo_id
                WHERE miembro.user_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function obtenerGruposNoPertenecidos($user_id) {
        $sql = "SELECT * FROM grupo WHERE grupo_id NOT IN (SELECT grupo_id FROM miembro WHERE user_id = ?)";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$user_id = $_SESSION['user_id']; // Obtén el ID de usuario de la sesión actual.

$grupo = new Grupo($conexion);

$gruposDeUsuario = $grupo->obtenerGruposDeUsuario($user_id);
$gruposNoPertenecidos = $grupo->obtenerGruposNoPertenecidos($user_id);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CHAT FIGHTERS || Grupos</title>
        <link rel="stylesheet" href="CSS/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/GruposChat.css">
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

            <main>
            <div id="Contenedor" style="display: flex;">
                    <div id="PanelInteriorIzq">
                        <aside class="sidebar">
                        <h1>Mis Grupos</h1>
                        <ul class="conversation-list">
                        <?php
                   while ($row = $gruposDeUsuario->fetch_assoc()) {
                   $grupo_id = $row['grupo_id'];
                   $gruponame = $row['gruponame'];
                   $grupopic = $row['grupopic'];

                   echo '<div class="Usu21">';
                   echo '<li data-grupo-id="' . $grupo_id . '">';
                   echo '<img src="data:image/jpeg;base64,' . $grupopic . '" class="profile-pic" alt="' . $gruponame . '">';
                   echo '<div class="contact-info">';
                   echo '<h5>' . $gruponame . '</h5>';
                   echo '<p class="message-info">';
                   echo '<br>';
                   echo '<br>';
                   echo '</p>';
                   echo '</div>';
                   echo '</li>';
                   echo '</div>';
                }
                ?>                            
                        </ul>
                    </aside>
                </div> 

                <div id="PanelInteriorDer">
                <section class="chat-container">
            <h1> Crea un grupo</h1>
            <a href="addgroup.php"><h3>Crea un Grupo Aquí</h3><a> <br><br>

            <h1> GRUPOS DISPONIBLES:</h1>
            <?php
            while ($row = $gruposNoPertenecidos->fetch_assoc()) {
                $grupo_id = $row['grupo_id'];
                $gruponame = $row['gruponame'];
                $grupopic = $row['grupopic'];

                echo '<div class="chat-header">';
                echo '<img src="data:image/jpeg;base64,' . $grupopic . '" class="profile-pic" alt="' . $grupopic . '">';
                echo '<h2>' . $gruponame . '</h2>';
                echo '<br>';
                echo '<a href="unirsegrupo.php?grupo_id=' . $grupo_id . '" class="btn btn-primary btn-sm btn-editar" style="position: relative; top: 20px; margin-left:15px; display: block; text-align: center; margin-bottom: 200px;">Unirse</a>';
                echo '</div>';
            }
            $conexionDB->cerrarConexion(); // Cierra la conexión a la base de datos.
            ?>
            </section>
                </div>
                
            </div>

            <script>
    // Agrega un evento de clic a los elementos <li> para redirigir al grupo seleccionado.
    const grupoItems = document.querySelectorAll('li[data-grupo-id]');
    grupoItems.forEach((item) => {
        item.addEventListener('click', function () {
            const grupoId = item.getAttribute('data-grupo-id');
            window.location.href = `grupochat.php?grupo_id=${grupoId}`;
        });
    });
</script>
    </main>
</body>

</html>
