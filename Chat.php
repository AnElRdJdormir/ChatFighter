<?php  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('contactos.php');

// Obtén el user_id de los parámetros de la URL
if (isset($_GET['user_id'])) {
    $selectedUserId = $_GET['user_id'];

    // Busca los detalles del usuario seleccionado en $contactDetails
    foreach ($contactDetails as $contact) {
        if ($contact["user_id"] == $selectedUserId) {
            $name = htmlspecialchars($contact["user"]);
            $picture = htmlspecialchars($contact["userpic"]);
            $state = htmlspecialchars($contact["user_estado"]);
            break; // Termina el bucle una vez que se encuentra el usuario
        }
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
    <link rel="stylesheet" href="CSS/ChatUsuario.css">
    <script src="JS/bootstrap.min.js"></script>
</head>
<body>
    <div id="IDChatU">
        <div id="PanelIzq">
            <div style="padding: 10px">
                <img id="FotoIcon" src="Images\POI\Icono.png">
                <?php  
                echo '<img id="FotoPerfil" src="data:image/jpeg;base64,' . $_SESSION['userpic'] . '" class="profile-pic">';
                echo '<br>';
                echo 'Nombre de Usuario: ' . htmlspecialchars($_SESSION['user']);
                echo '<br>';
                echo 'Correo: ' . htmlspecialchars($_SESSION['useremail']);
                echo '<br>';
                echo '<button class="BotonEdit"><a href="profile.php">Editar Usuario</a></button>';
                ?>  
            </div>
        </div>

        <div id="PanelDer">
            <div id="Encabezado">
                <ul class="navbar-nav" id="navGrid" style="list-style-type: none; padding: 0;">
                    <li class="nav-item"><a class="nav-link" href="ChatUsuario.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="grupos.php">Grupos</a></li>
                    <li class="nav-item"><a class="nav-link" href="cerrar_sesion.php">Cerrar Sesión</a></li>
                </ul>
            </div>

            <div id="Contenedor" style="display: flex;">
                <div id="PanelInteriorIzq">
                    <aside class="sidebar">
                        <h1>Conversaciones</h1>
                        <ul class="conversation-list">
                        <?php
                            foreach ($contactDetails as $contact) {
                                $contactName = htmlspecialchars($contact["user"]);
                                $contactPic = htmlspecialchars($contact["userpic"]);
                                $userId = htmlspecialchars($contact["user_id"]);
                                $user_estado = htmlspecialchars($contact["user_estado"]);
                                
                                $messageCountClass = ($user_estado === 'offline') ? 'offline' : 'online';
                                $messagePreview = ($user_estado === 'offline') ? 'Offline' : 'Online';
                                
                                echo '<li class="Usu21" data-userid="' . $userId . '">';
                                echo '    <img src="data:image/jpeg;base64,' . $contactPic . '" class="profile-pic" alt="' . $contactName . '">';
                                echo '    <div class="contact-info">';
                                echo '        <h5>' . $contactName . '</h5>';
                                echo '        <p class="message-info">';
                                echo '            <span class="message-count ' . $messageCountClass . '">&nbsp;</span>';
                                echo '            <span class="message-preview">' . $messagePreview . '</span>';
                                echo '        </p>';
                                echo '    </div>';
                                echo '</li>';
                            }
                        ?>
                        </ul>
                    </aside>
                </div>

                <div id="PanelInteriorDer">
                    <section class="chat-container">
                        <div class="chat-header">
                            <?php 
                                $estadomensajes = ($state == 'offline') ? 'Pendientes' : 'Recibidos';
                            ?>
                            <img src="data:image/jpeg;base64,<?php echo $picture; ?>" class="profile-pic" alt="<?php echo $name; ?>">
                            <h2><?php echo htmlspecialchars($name); ?></h2>
                            <br>
                            <a href="https://console-api-sig.zegocloud.com/s/uikit/vI7FV3">
                                <img src="Images/POI/videochat2.png" style="margin-top: -5px; margin-left: 25px; width: 80px; height: 80px;">
                            </a>
                        </div>

                        <div class="chat-messages">
                            <?php
                                $usuario_id = $_SESSION['user_id'];
                                if (isset($selectedUserId)) {
                                    $messages = $listaDeContactos->obtenerMensajes($usuario_id, $selectedUserId);
                                    foreach ($messages as $message) {
                                        $messageText = htmlspecialchars($message['text']);
                                        $messageImg = $message['img'];
                                        $isIncoming = $message['user_id'] != $usuario_id;
                                        $messageClass = $isIncoming ? 'message incoming' : 'message outgoing';
                            ?>
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
                        <h5 style="margin-top: 65px; margin-left: 1020px;">Los mensajes se encuentran: <?php echo $estadomensajes;?></h5>

                        <div class="compose">
                            <form action="main.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="selected_user_id" value="<?php echo $_GET['user_id']; ?>">
                                <label for="edit_imagen" class="form-label">Seleccionar imagen</label>
                                <input class="form-control" type="file" id="edit_imagen" name="edit_imagen" accept="image/*">

                               <br>
                                <input type="text" placeholder="Escribe un mensaje..." name="mensaje" id="ubicacionInput">
                                <button>Enviar</button>
                            </form>
                            <button onclick="obtenerUbicacion()" style="margin-top:116px;max-width: 100px; max-height: 40px;">Localizar</button>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactItems = document.querySelectorAll('li[data-userid]');
        contactItems.forEach(function(item) {
            item.addEventListener('click', function() {
                const userId = item.getAttribute('data-userid');
                window.location.href = `Chat.php?user_id=${userId}`;
            });
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
</body>
</html>