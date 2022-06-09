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

    <link href="../assets/css/obrasxcop.css" rel="stylesheet" />
    <style>
        body, html {
            background-image: url('../assets/imgs/bg.jpg');
            background-size: cover;
            height: 100%;
        }

        .login{
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 15px;
        }
        .inputblock{
            color: #fff;
            margin-bottom: 20px;
        }
        .inputblock input{
            width: 100%;
            padding: 10px;
            border: 0;
            border-radius: 10px;
        }
        .btnPropio{
            background-color: #fff;
        }
        .errorcontainer{
            background-color: #e8de59;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: center;
        }
    </style>
    <title>SIIM_V1.2</title>
</head>

<body>
    <div class="container">
        <div class="col-lg-3 col-md-6 col-sm-12 mx-auto row tarjetaLogin">

            <div class="col-12 login">
                <div class='letreroLogin' style="color:#fff; padding:10px;">
                <img src="../assets/imgs/escudo_st.png" style="width:100%;" />
                    <h3><b>SIIM_V1.2</b></h3>
                    <p>Sistema de Información Integral Municipal</p>
                </div>
                
                <form id="loginForm" class="loginBox">
                    <div class="inputblock">
                        <label for="email">Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required
                            placeholder="Ingresa tu email"
                            onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}" />
                    </div>

                    <div class="inputblock">
                        <label for="password">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            placeholder="Ingresa tu password"
                            onkeydown="if(event.key === 'Enter'){event.preventDefault();login();}" />
                    </div>
                    <br>
                    <div id="errs" class="errorcontainer"></div>
                    <div class="text-center">
                        <div class="btn btnPropio" onclick="login();">Ingresar</div>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <!-- <a href="./resetpassword.php">¿Olvidaste tu contraseña?</a> -->
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script src="../assets/js/formularios.js"></script>
</body>

</html>