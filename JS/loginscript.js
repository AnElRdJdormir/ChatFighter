document.addEventListener('DOMContentLoaded', function () {

    const loginForm = document.getElementById('loginForm');
    const alertBox = document.getElementById('alert');
    const emailInput = document.getElementById('log_mail');

    loginForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Evita que el formulario se envíe

        const email = emailInput.value;
        // Valida el formato del correo electrónico utilizando una expresión regular
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailPattern.test(email)) {
            alertBox.innerHTML = '<strong>Error:</strong> El formato del correo electrónico no es válido.';
            alertBox.className = 'alert alert-danger';
            alertBox.style.display = 'block';
            return;
        }
        
        const formData = new FormData(loginForm);
        fetch('iniciosesion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                alertBox.innerHTML = data.message;
                alertBox.className = 'alert alert-success';
                alertBox.style.display = 'block';
                setTimeout(function () {
                    window.location.href = 'logstatus.php';
                }, 2000);

            } else if (data.status === 'error') {
                alertBox.innerHTML = data.message;
                alertBox.className = 'alert alert-danger';
                alertBox.style.display = 'block';
                setTimeout(function () {
                    alertBox.style.display = 'none';
                }, 2000);
            }
        });
    });
});