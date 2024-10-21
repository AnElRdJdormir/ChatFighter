<?php  
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('contactos.php');
$user_id = $_SESSION['user_id'];

$contactosNoPertenecidos = $listaDeContactos -> ObtenerContactosNoPertenecidos($user_id);

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>CHAT FIGHTERS || Chats de Usuarios</title>
        <link rel="stylesheet" href="CSS/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/UserProfileDesign.css">
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
                echo '<button class="BotonEdit">Editar Usuario</button>';
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
                            <a class="nav-link" href="#">Llamadas</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#">Grupos</a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="Login.html">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>

                <div id="Contenedor" style="display: flex;">
                    <div id="PanelInteriorIzq">
                        <aside class="sidebar">
                        <h1>Conversaciones</h1>
                        <ul class="conversation-list">
            <?php
                   foreach ($contactDetails as $contact) {

                    $contactName = $contact["user"];
                    $contactPic = $contact["userpic"];
                    $userId = $contact["user_id"]; 
                    $user_estado = $contact["user_estado"];
                    $messageCountClass = ($user_estado == 'offline') ? 'offline' : 'online';
                    $messageCountClass2 = ($user_estado == 'offline') ? 'Offline' : 'Online';

                    echo '<li class="Usu21" data-userid="' . $userId . '">';
                    echo '<img src="data:image/jpeg;base64,' . $contactPic . '" class="profile-pic" alt="' . $contactName . '">';
                    echo '<div class="contact-info">';
                    echo '<h5>' . $contactName . '</h5>';
                    echo '<p class="message-info">';
                    echo '<span class="message-count ' . $messageCountClass . '">&nbsp;</span>';
                    echo '<span class="message-preview">'. $messageCountClass2. '</span>';
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
                    <h3 style="position: relative;"> CHOOSE YOUR CHARACTER / </h3>

        <h3 style="position: relative;"> AGREGA CONTACTOS: </h3>

        <?php
          while ($row = $contactosNoPertenecidos->fetch_assoc()) {
              $contname = $row["user"];
              $contpic = $row["userpic"];
              $cont_id = $row["user_id"]; 

              echo '<div class="chat-header">';
              echo '<img src="data:image/jpeg;base64,' . $contpic . '" class="profile-pic" alt="' . $contpic . '">';
              echo '<h2>' . $contname .'</h2>';
              echo '<br>';

              echo '<a href="unirsechat.php?cont_id=' . $cont_id . '" class="btn">Agregar Usuario</a>';

              echo '</div>';
          }
          $conexionDB->cerrarConexion(); // Cierra la conexión a la base de datos.
          ?>
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
</script>

<script type="text/javascript">

</script>
    </body>
</html>

