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
            $name = $contact["user"];
            $picture = $contact["userpic"];
            $state = $contact["user_estado"];
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
    <title>CHAT FIGHTERS || Crear Grupos</title>
    <link rel="shortcut icon" href="images/icon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/registerstyle.css" />
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
    <div id="scroll-target"></div>
    
    <div id="alert-success" class="alert alert-dismissible alert-success" style="display: none;">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Grupo Creado Correctamente</strong> 
    </div>
    
    <div id="alert-error" class="alert alert-dismissible alert-danger" style="display: none;">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <strong>Error: Por favor, corrija los campos resaltados.</strong> 
    </div>


    <div id="idRegister" class="form-box form-value container">
            <form action ="agregargrupo.php" id="registerForm" method="POST" enctype="multipart/form-data">
        
            <div class="row">
                <label id="idRegisterTitulo" class="text">CREAR GRUPO</label>
            </div>
            <div class="row">
                <div class="col">
                    <div class="idRegisterAvatar">
                        <div class="Titulo">
                            <img id="idImagen" src="Images/POI/Icono.png" width="300px" />
                        </div>

                        <div class="d-flex justify-content-center">
                            <img id="idRegisterAvatarSample" src="Images/POI/random.png" 
                            class="rounded-circle"alt="example placeholder">
                        </div>
                        
                        
                    </div>
                    <div class="d-flex justify-content-center" >
                        <div id="grupo_pic" name="grupo_pic" class="btn btn-primary btn-rounded">
                            <input class="form-control" type="file" id="formFile" id="grupo_pic" name="grupo_pic"  onchange="mostrarAvatar(event, 'idRegisterAvatarSample')" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div id="idRegisterInputs" class="inputbox">
                        <label for="ffullname">Nombre del Grupo:</label>
                        <input id="grupo_nombre" name="grupo_nombre" type="text" required>
                    </div>

                <div class="col">
                    <div id="idRegisterBtns2" class="d-flex justify-content-between">
                        <button id="btnRegister" type="submit">Confirmar Grupo</button>                   
                    </div>

                    <ul class="navbar-nav mr-auto" id="Return">
                        <li class="nav-item active">
                            <a class="submit" href="grupos.php">Regresar</a>
                        </li>
                    </ul>

                    <br>
                </div>
            </div>
            </form>
            <script src="js/Register.js"></script>            
        </div>
</div>
    </body>
</html>