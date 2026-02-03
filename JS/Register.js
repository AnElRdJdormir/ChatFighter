
function mostrarAvatar(event, elementId) {
    const selectedImage = document.getElementById(elementId);
    const fileInput = event.target;

    if (fileInput.files && fileInput.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            selectedImage.src = e.target.result;
        };
        reader.readAsDataURL(fileInput.files[0]);
    }
}

// Funcion para deshabilitar el combobox de 'Privacidad' si eres Admin o Vendedor
// $(function(){
//     var arrVal = ["1"];
  
//     $("#idRegisterRol").change(function(){
//       var valToCheck = String($(this).val());
  
//         if ( jQuery.inArray(valToCheck,arrVal) == -1 ){
//             $("#idRegisterChB").attr("disabled", "true");
//             if ($("#idRegisterChB").val('2')) {
//                 $("#idRegisterChB").val('1');
//             }
//         }
//         else{
//             $("#idRegisterChB").removeAttr ( "disabled" );
//         }
//     });
// });

// Funcion para ocultar la opcion "Privado" del combobox 'Privacidad' si eres Admin o Vendedor
$(function(){
    var arrVal = ["1"];
  
    $("#idRegisterRol").change(function(){
      var valToCheck = String($(this).val());
  
        if ( jQuery.inArray(valToCheck,arrVal) == -1 ){
            $("#dropdownPrivacy2").attr("hidden", "true");
            if ($("#idRegisterChB").val('2')) {
                $("#idRegisterChB").val('');
            }
        }
        else{
            $("#dropdownPrivacy2").removeAttr( "hidden" );
        }
    });
});


$(document).ready(function(){

    $('#btnRegister').click(function(){
        var nombre = $('#txtFullname').val();
        var usuario = $('#txtUsername').val();
        var contrasena = $('#txtPassword').val();
        var correo = $('#txtEmail').val();
        var fecha = $('#txtBirthdate').val();
        var genero = "NB";
        var rol = $("#idRegisterRol").val();
        var avatar = $('#btnRegisterAvatar').val();
        var publico = $("#idRegisterChB").val();

        if($('#RBH').is(":checked")){
            genero = "H";
        }else if($('#RBM').is(":checked")){
            genero = "M";
        }

        if (rol == "") {
            alert("No se ha seleccionado ninguna opción dentro de la lista 'Rol', por favor escoja una");
            return false;
        }

        if (publico == "") {
            alert("No se ha seleccionado ninguna opción dentro de la lista 'Privacidad', por favor escoja una");
            return false;
        }

        if(nombre == ""){
            alert("No se ha llenado el campo 'Nombre completo', por favor escríbalo.");
            return false;
        }else if(usuario == ""){
            alert("No se ha llenado el campo 'Nombre de Usuario', por favor escríbalo.");
            return false;
        }else if(correo == ""){
            alert("No se ha llenado el campo 'Correo electrónico', por favor escríbalo.");
            return false;
        }else if(contrasena == ""){
            alert("No se ha llenado el campo 'Contraseña', por favor escríbalo.");
            return false;
        }


        if(usuario.length < 3){
            alert("El nombre de usuario debe contener un mínimo de 3 carácteres.");
            return false;
        }

        regexPattern = /^(?=.*[-\#\$\.\%\&\@\!\+\=\\*])(?=.*[a-zA-Z])(?=.*\d).{8,12}$/;
        if(contrasena.match(regexPattern))
        {
            console.log("Contrasena aprobada.");
        }
        else{
            alert("La contraseña debe contener un mínimo de 8 carácteres, una mayúscula, una minúscula, un número y un carácter especial.");
            return false;
        }

        if(!isEmail(correo)){
            alert("Escriba su correo correctamente");
            return false;
        }

        if(fecha == "")
        {
            alert("Inserte su fecha de nacimiento.");
            return false;
        }
        if(imagen == "")
        {
            alert("Inserte una foto de perfil.");
            return false;
        }

        console.log("Nombre: " + nombre);
        console.log("Usuario: " + usuario);
        console.log("Contra: " + contrasena);
        console.log("Correo: " + correo);
        console.log("Fecha: " + fecha);
        console.log("Genero: " + genero);
        console.log("Rol: " + rol);
        console.log("Privacidad: " + publico);
        console.log("Avatar: " + avatar);

        $.ajax({
            type: "post",
            url:"registro.php",
            data: {"username": usuario, "name": nombre, "password": contrasena, 
            "email": correo, "birthdate": fecha, "gender": sexo,
            "role": rol, "foto": avatar, "privacy": publico},
            success: function(){
                alert("Usuario creado!");
                window.location.href='Dashboard2.html';
            },
            error: function(err) {
                console.log("AJAX error in request: " + JSON.stringify(err, null, 2));
                alert("Error al crear usuario, intente de nuevo.");
            }
        });
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    }
});