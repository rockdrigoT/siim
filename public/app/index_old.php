<?php 
require_once '../../src/utils.php';
include  '../../src/verificaUser.php'; 
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link href="../assets/css/com_ind.css" rel="stylesheet" />
    <link href="../assets/css/loader.css" rel="stylesheet" />
    <link href="../assets/css/dashboard.css" rel="stylesheet" />
    <title>SIIM_V1.2</title>
</head>

<body>
    <!-- loader -->
    <div id='loader'>
        <div class="spinner"></div>
    </div>

    <script>
    window.addEventListener('load', function load() {
        const loader = document.getElementById('loader');
        setTimeout(function() {
            loader.classList.add('fadeOut');
        }, 300);
    });
    </script>

    <?php include('../templates/header.php') ?>

    <div class="container">
        <?php include('../templates/sidebar.php') ?>
    </div>


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        

        <div class="col-8 mx-auto">
            <div class="row">
             a
            </div>
        </div>

    </main>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script src="../assets/js/formularios.js"></script>
</body>

</html>