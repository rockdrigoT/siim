<?php 
	require_once '../../src/utils.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf_token" content="<?php echo createToken(); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="../assets/css/sisogem.css" rel="stylesheet" />
    <title>SIIM_V1.2</title>
    
</head>

<body>

    <div class="container">
        <div class="topRegistroBox col-lg-4 col-md-5 col-sm-10 mx-auto">
            <h1 class="text-center text-light p-2">Registro SIIM</h1>
            <p class='text-center pb-4'>Sistema Integral de Información Municipal</p>
        </div>
        <div class="card col-lg-4 col-md-5 col-sm-10 mx-auto p-3">

            <form id="registerForm">

                <div id="errs" class="errcontainer"></div>
                <div class="inputblock">
                    <label for="name"><i class="bi bi-person-circle"></i> Nombre</label>
                    <input id="name" name="name" type="text" autocomplete="name" placeholder="nombre"
                        onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" required />
                </div>

                <div class="inputblock">
                    <label for="cargo"><i class="bi bi-person-circle"></i> Cargo</label>
                    <input id="cargo" name="cargo" type="text" autocomplete="cargo" placeholder="cargo" required />
                </div>

                <div class="inputblock">
                    <label for="email"><i class="bi bi-envelope"></i> Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" placeholder="email"
                        onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" required />
                </div>

                <div class="inputblock">
                    <label for="password"><i class="bi bi-key"></i> Password</label>
                    <input id="password" name="password" type="password" autocomplete="new-password"
                        placeholder="password"
                        onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" required />
                </div>

                <div class="inputblock">
                    <label for="confirm-password"><i class="bi bi-key"></i> Confirma Password</label>
                    <input id="confirm-password" name="confirm-password" type="password" autocomplete="new-password"
                        placeholder="Confirma password"
                        onkeydown="if(event.key === 'Enter'){event.preventDefault();register();}" required/>
                </div>

                <div class="inputblock">
                    <label for="upp"><i class="bi bi-building"></i> UPP</label>
                    <input id="upp" name="upp" type="text" placeholder="UPP"/>
                </div>

                <br>
                <div class="text-center">
                    <div class="btn btn-primary" onclick="register();">Registra el usuario</div>
                </div>
                <br>
                <div class="text-center"><a href="./login.php">¿Ya cuentas con usuario?</a></div>

            </form>
        </div>

    </div>


    <script src="../assets/js/formularios.js"></script>
</body>

</html>