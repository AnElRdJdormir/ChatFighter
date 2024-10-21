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
        <title>CHAT FIGHTERS || Menu del Chat</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="CSS/bootstrap.min.css">
        <link rel="stylesheet" href="CSS/UserProfileDesign.css">
        <script src="JS/bootstrap.min.js"></script>
    </head>

    <body id="idBody">
        <!-- NAVEGADOR -->
         <header>
            <nav id="idNav1" class="navbar navbar-expand-md">
                <button id="idTituloTienda" class="navbar-brand d-flex mr-auto" type="button">
                    <img src="Images/POI/Icono.png" width="190px"/>
                </button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
    
                <div class="navbar-collapse collapse order-1 order-md-0 dual-collapse2" id="idNavLinks1">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a id="idNavOptions1" class="nav-link" href="#">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a id="idNavOptions1" class="nav-link" href="#">Llamadas</a>
                        </li>
                        <li class="nav-item">
                            <a id="idNavOptions1" class="nav-link" href="#">Grupos</a>
                        </li>
                        <li class="nav-item">
                            <a id="idNavOptions1" class="nav-link" href="Login.html">Cerrar Sesión</a>
                        </li>
                    </ul>
                </div>
            </nav>
         </header>


         <main>
            
            <!--Barra de Perfil-->
            <aside class="sidebar" id="sidebar">
                <h1>Perfil del Usuario</h1>
                <ul class="List-info-usua">
                    <div class="imagen-Usua">

                    <img src="data:image/jpeg;base64,<?php echo $_SESSION['userpic'];?>" id="idRegisterAvatarSample" alt="Foto de perfil" class="rounded-circle" alt="example placeholder">
                    
                    </div>

                        <div class="info-Usua" id="info-Usua">
                            <!--Nombre del Usuario-->
                            <h5 class="Nombre">Pikachu</h5>
                            
                            <!--Correo electronico-->
                            <h5 class="Correo">Correo electronico</h5>
                            
                            <!--Estatus del Usuario-->
                            <h5 class="Estatus">Activo/Inactivo</h5>

                            <button id="Editar">Editar Perfil</button>
                        </div>

                </ul>
            </aside>


            <section class="chat-container">
                <div class="row justify-content-md-center">
                    
                        <br>
                        <div class="profile">
                            <table id="idVUTabla" class="table">
                                <thead>
                                    <tr>
                                        <th class="item-1">Foto de Perfil</th>
                                        <th>Usuario</th>
                                        <th>Ultimo Mensaje</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="imageSeller">
                                            <img id="idRegisterAvatarSample" src="Images/POI/Mario.png" class="rounded-circle" alt="example placeholder" loading="lazy">
                                        
                                        </td>
                                        <td> Mario </td>
                                        <td>It's a me!!!</td>
                                        <td>
                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Chat</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Eliminar</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Invitar</a>
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <td class="imageSeller"><img src="Images/POI/Sonic.png" alt="product_img" class="rounded-circle">
                                        </td>
        
                                        <td> Sonic </td>
                                        <td>You to slow</td>
                                        <td>
                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Chat</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Eliminar</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Invitar</a>
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <td class="imageSeller"><img src="Images/POI/Link.png" alt="product_img" class="rounded-circle">
                                        </td>
        
                                        <td> Link </td>
                                        <td>Hiaaa!!!</td>
                                        <td>
                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Chat</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Eliminar</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Invitar</a>
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <td class="imageSeller"><img src="Images/POI/Samus.png" alt="product_img" class="rounded-circle">
                                        </td>
        
                                        <td> Samus </td>
                                        <td>*</td>
                                        <td>
                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Chat</a>

                                             <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Eliminar</a>

                                            <a href="#"type="submit" name="chat" class="btn btn-success chatSeller">Invitar</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
            </section>
        </main>
 <br>
 <br>
 <br>
 <br>


 <script>
    document.addEventListener('DOMContentLoaded', function() {
        const contactItems = document.querySelectorAll('li[data-userid]');
        contactItems.forEach(function(item) {
            item.addEventListener('click', function() {
                const userId = item.getAttribute('data-userid');
                window.location.href = `main.php?user_id=${userId}`;
            });
        });
    });

    setTimeout(function(){
        location.reload();
    }, 25000);
</script>

<script type="text/javascript">

</script>



        <!-- FOOTER -->
        <footer id="idFooter" class="container-fluid py-2">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item">
                    <a id="idFooterLinks" href="#" class="nav-link text-body-secondary">Inicio</a>
                </li>
                <li class="nav-item">
                    <a id="idFooterLinks" href="#" class="nav-link text-body-secondary">Contacto de Soporte</a>
                </li>
                <li class="nav-item">
                    <a id="idFooterLinks" href="#" class="nav-link text-body-secondary">FAQ</a>
                </li>
            </ul>
            <p class="text-center text-body-secondary">Copyright © 2024 Angel Eliud Rodríguez Jordán</p>
        </footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
</html>