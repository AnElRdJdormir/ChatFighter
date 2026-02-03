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

    public function obtenerInformacionGrupo($grupo_id) {
        $sql = "SELECT * FROM grupo WHERE grupo_id = ?";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $grupo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }


    public function obtenerPublicaciones($grupo_id) {
        $sql = "SELECT pubtexto, pubimg, nomb_usuario FROM publicacion WHERE groupid = ?;";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $grupo_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $messages = array();
    
        while ($row = $result->fetch_assoc()) {
            $message = array(
                'publi_txt' => $row['pubtexto'],
                'us_name' => $row['nomb_usuario'],
                'publi_img' => $row['pubimg']
            );
            $messages[] = $message;
        }
    
        return $messages;
    }

}

$conexionDB = new ConexionDB();
$conexion = $conexionDB->getConexion();

$user_id = $_SESSION['user_id']; 

$grupo = new Grupo($conexion);

$gruposDeUsuario = $grupo->obtenerGruposDeUsuario($user_id);

$grupo_id = $_GET['grupo_id'];


$informacionGrupo = $grupo->obtenerInformacionGrupo($grupo_id);

if ($informacionGrupo) {
    $gruponame = $informacionGrupo['gruponame'];
    $grupopic = $informacionGrupo['grupopic'];
} else {
    echo "Grupo no encontrado";
}


?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CHAT FIGHTERS || Grupo </title>
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
                    $grupo_id_list = $row['grupo_id'];
                    $gruponame_list = $row['gruponame'];
                    $grupopic_list = $row['grupopic'];

                    echo '<li  data-grupo-id="' . $grupo_id_list. '">';
                    echo '<img src="data:image/jpeg;base64,' . $grupopic_list . '" class="profile-pic" alt="' . $gruponame_list . '">';
                    echo '<div class="contact-info">';
                    echo '<h5>' . $gruponame_list . '</h5>';
                    echo '<p class "message-info">';
                    echo '<br>';
                    echo '<br>';
                    echo '</p>';
                    echo '</div>';
                    echo '</li>';
                }
                ?>
            </ul>
        </aside>
        </div> 

                <div id="PanelInteriorDer">
        <section class="chat-container">
            <div class="chat-header">
                <img src="data:image/jpeg;base64,<?php echo $grupopic; ?>" class="profile-pic" alt="<?php echo $gruponame; ?>">
                <h2><?php echo $gruponame; ?></h2>
            </div>
            <div class="chat-messages">

            <?php
                $nombreusuario = $_SESSION['user'];
                if (isset($grupo_id)) {
                    $messages = $grupo->obtenerPublicaciones($grupo_id);
                    foreach ($messages as $message) {
                        $messageText = $message['publi_txt'];
                        $messageImg = $message['publi_img'];
                        $AuthorText = $message['us_name'];
                        $isIncoming = $message['us_name'] != $nombreusuario;
                        $messageClass = $isIncoming ? 'message incoming' : 'message outgoing';
                        $messageAuthor = $isIncoming ? '55px' : '910px';
                ?>
                <h6 style="margin-left: <?php echo $messageAuthor; ?>">enviado por: <?php echo $AuthorText; ?></h6>
                <div class="<?php echo $messageClass; ?>">
                    <?php if (!empty($messageText)) { ?>
                    <p><?php echo $messageText; ?></p>
                    <?php } ?>
                        <?php if (!empty($messageImg)) { ?>
                          <img src="data:image/jpeg;base64,<?php echo $messageImg; ?>" alt="Imagen del chat" style="max-width: 200px; max-height: 200px;">
                        <?php } ?>
                </div>
                <?php
                    }
                }
                ?>
            </div>       
            <div class="compose">
            <form action="publicacion.php" method="POST" enctype="multipart/form-data">
         
                    <input type="hidden" name="selected_group_id" value="<?php echo  $_GET['grupo_id']; ?>">
                    <label for="formFile" class="form-label">Seleccionar imagen</label>
                    <input class="form-control" type="file" id="formFile" id="edit_imagen" name="edit_imagen" accept="image/*">
                    <br>
                    <input type="text" placeholder="Escribe un mensaje..." id="ubicacionInput" name="mensaje">
                    <button>Enviar</button>
    
                </form>
                <button onclick="obtenerUbicacion()" style="margin-top:116px;max-width: 100px; max-height: 40px;">Localizar</button>
            </div>


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

    setTimeout(function(){
        location.reload();
    }, 25000);


    function obtenerUbicacion() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          obtenerDatosUbicacion(position.coords.latitude, position.coords.longitude);
        });
      } else {
        alert("La geolocalización no está soportada por tu navegador.");
      }
    }
    
    function obtenerDatosUbicacion(lat, lon) {
      const url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`;
      
      fetch(url)
        .then(response => response.json())
        .then(data => {
          const ciudad = data.address.city || data.address.village || data.address.town;
          const estado = data.address.state;
          const calle = data.address.road || data.address.street;
          const pais = data.address.country;
          
          // Modificar el valor del input con la información de ubicación
          document.getElementById('ubicacionInput').value = `Ciudad: ${ciudad}, Estado: ${estado}, Calle: ${calle}, País: ${pais}`;
        })
        .catch(error => {
          console.error("Error al obtener datos de ubicación:", error);
        });
    }

</script>

    </main>
</body>
</html>