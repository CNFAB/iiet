<!DOCTYPE html>

<html>
<head>
    <title>Login - GeohelmintSoft</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    
    <link rel="stylesheet" href="/iiet/assets/css/bootstrap.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/colores.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/tema-iiet.css"/>
    <link rel="stylesheet" href="/iiet/assets/css/fa-all.min.css"/>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400" rel="stylesheet"/>

    <style type="text/css">
        header {
            border: none;
        }

        header > p {
            color: var(--iiet-gray);
        }
    </style>
</head>
<body>
    <section class="container pt-5">
        <header class="row justify-content-center pt-5 mb-5">
            <p class="col-12 text-center">BIENVENIDO A</p>
            <h1 class="col-12 text-center">GeohelmintSoft</h1>
        </header>
        <div class="row justify-content-center">
            <div id="alertas" class="col-4"></div>
        </div>
        <div class="row justify-content-center">
            <form name="login" method="POST" action="" class="col-10 col-lg-4">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="identity" class="form-control" required autofocus autocomplete="off" />
                </div>
                <div class="form-group">
                    <label>Contrase&ntilde;a</label>
                    <input type="password" name="password" class="form-control" required autofocus autocomplete="off" />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary btn-block" value="Ingresar" />
                </div>
            </form>
        </div>
        <div class="row justify-content-center">
            <a href="/iiet/index.php/auth/forgot_password" class="col-10 col-lg-4">¿Olvidaste tu contrase&ntilde;a?</a>
        </div>
    </section>
</body>
<script src="/iiet/assets/js/jquery-3.3.1.min.js"></script>
<script src="/iiet/assets/js/popper.min.js"></script>
<script src="/iiet/assets/js/bootstrap.min.js"></script>
<script>

document.login.addEventListener('submit', function(e) {
    e.preventDefault();

    // 🔧 CORREGIDO: Usar index.php en la URL
    $.ajax('/iiet/index.php/auth/login/TRUE', {
        dataType: 'json',
        method: 'POST',
        data: $(this).serialize(),
        success: function(respuesta) {
            if(respuesta === false) {
                errorLogin();
            } else {
                // 🔧 CORREGIDO: Usar index.php en la redirección
                window.location.href = '/iiet/index.php/inicio/seleccion_modo';
            }
        },
        error: function() {
            errorLogin();
        }
    });
}); 

function errorLogin() {
    var p = document.createElement('p'),
        button = document.createElement('button');

    p.className = 'alert alert-danger';
    p.textContent = 'Usuario o contraseña incorrectos.';

    button.type = 'button';
    button.className = 'close';
    button.dataset.dismiss = 'alert';
    button.textContent = '\xd7';

    p.appendChild(button);

    $('#alertas')[0].appendChild(p);

    document.login.identity.focus();
}

</script>
</html>