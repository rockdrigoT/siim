<?php 
// 	require_once '../../src/utils.php';
//   include  '../../src/verificaUser.php'; 
//   $miUpp = $_SESSION['miupp'];
//   $micargo = $_SESSION['cargo'];
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <!-- PLUGINS CHARTS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    

    <link href="assets/css/com_ind.css" rel="stylesheet" />
    <link href="assets/css/loader.css" rel="stylesheet" />
    <link href="assets/css/dashboard.css" rel="stylesheet" />
    <title>SIIM_V1.1</title>

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

    <?php include('templates/header.php') ?>

    <div class="container">
        <?php include('templates/sidebar.php') ?>
    </div>


    <main class="col-md-9 ms-sm-auto col-lg-11 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Obras de infraestructura en Michoacán 2022</h1>
            <div class="col-lg-2 col-md-6 col-sm-12 mx-auto">
            <div class="card m-3 text-white bg-primary ">
            <h5 class="card-header text-center">Obras</h5>
                    <div class="card-body"><h1 class="text-center text-white">
                        <?php
                            $conn = new mysqli('localhost', 'root', 'root', 'infraestructura_michoacan') or die(mysqli_error());	
                            $sql = $conn->prepare("SELECT count(id) AS obras FROM acciones");
                            if($sql->execute()){
                                $g_result = $sql->get_result();
                            }
                            while($row = $g_result->fetch_array()){
                            echo number_format($row['obras'],0);
                                }
                        ?></h1>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-12 mx-auto">
            <div class="card m-3 text-white bg-primary ">
            <h5 class="card-header text-center">Municipios</h5>
                    <div class="card-body"><h1 class="text-center text-white">
                    <?php
                            $sql = $conn->prepare("SELECT count(distinct municipio) AS mun_apoyados FROM acciones");
                            if($sql->execute()){
                                $g_result = $sql->get_result();
                            }
                            while($row = $g_result->fetch_array()){
                                echo number_format($row['mun_apoyados'],0);
                                }
                        ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-6 col-sm-12 mx-auto">
            <div class="card m-3 text-white bg-primary ">
            <h5 class="card-header text-center">Localidades</h5>
                    <div class="card-body"><h1 class="text-center text-white">
                    <?php
                            $sql = $conn->prepare("SELECT count(distinct localidad) AS loc_apoyados FROM acciones");
                            if($sql->execute()){
                                $g_result = $sql->get_result();
                            }
                            while($row = $g_result->fetch_array()){
                                echo number_format($row['loc_apoyados'],0);
                                }
                        ?>
                        </h2>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12 mx-auto">
            <div class="card m-3 text-white bg-success ">
            <h5 class="card-header text-center">Inversión</h5>
                    <div class="card-body"><h1 class="text-center text-white">
                    <?php
                            $sql = $conn->prepare("SELECT sum(monto) AS total_inv FROM acciones");
                            if($sql->execute()){
                                $g_result = $sql->get_result();
                            }
                            while($row = $g_result->fetch_array()){
                            echo '$'.number_format($row['total_inv'],2);
                                }
                        ?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-4">

            <div class="col-lg-12 col-md-12 col-sm-12">

            <div class="card m-3">
                    <h5 class="card-header">Obras por municipio</h5>
                    <div class="card-body">
                        <canvas id="grafica_municipios"></canvas>
                    </div>
                </div>

            </div>

           



            <script type="text/javascript">
            (async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch("get_data_chart.php");
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();
                // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica");
                const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const acciones = {
                    label: "obras por municipio",
                    // Pasar los datos igualmente desde PHP
                    data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
                    backgroundColor: 'rgba(144, 12, 65, 0.4)', // Color de fondo
                    borderColor: 'rgba(144, 12, 65, 1)', // Color del borde
                    borderWidth: 2, // Ancho del borde
                    fill: true,
                    barPercentage: true
                };
                new Chart($grafica, {
                    type: 'radar', // Tipo de gráfica
                    options:{
                        plugins: {
                            datalabels:{
                                color: 'pink'
                            }
                        }
                    },
                    data: {
                        labels: etiquetas,
                        datasets: [
                            acciones,
                        ]
                    }
                });
            })();

            (async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch("get_data_chart_municipios.php");
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();
                // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica_municipios");
                const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
               

                new Chart($grafica, {
                    type: 'line', // Tipo de gráfica

                    data: {
                        labels: etiquetas,
                        datasets: [
                            {
                                label: 'obras',
                                data: respuesta.datos,
                                borderColor: 'rgba(238, 80, 7, 0.8)',
                                backgroundColor: 'rgba(238, 80, 7, 0.2)',
                                yAxisID: 'y',
                                pointStyle: 'circle',
                                pointRadius: 10,
                                pointHoverRadius: 15
                                },
                            {
                                label: 'inversión',
                                data: respuesta.datos_monto,
                                borderColor: 'rgba(228, 180, 4, 0.8)',
                                backgroundColor: 'rgba(228, 180, 4, 0.2)',
                                yAxisID: 'y1',
                                pointStyle: 'circle',
                                pointRadius: 5,
                                pointHoverRadius: 15
                            }
                        ]
                    },

                    options: {
                        responsive: true,
                        interaction: {
                            mode: 'index',
                            intersect: false,
                        },
                        stacked: false,
                        plugins:{
                           title: {
                               display: false,
                               text: 'inversión / obras'
                           }
                       },
                       scales: {
                           y: {
                               type: 'linear',
                               display: true,
                               position: 'left',
                           },
                           y1: {
                               type: 'linear',
                               display: true,
                               position: 'right',
                               grid: {
                                drawOnChartArea: false,
                               }
                           }
                       }
                    }
                });
            })();

            (async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch("get_data_chart_upp.php");
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();
                // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica_upp");
                const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const acciones = {
                    label: "obras por programa",
                    // Pasar los datos igualmente desde PHP
                    data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
                    backgroundColor: 'rgba(0, 110, 127, 0.8)', // Color de fondo
                    borderColor: 'rgba(0, 110, 127,0.9)', // Color del borde
                    borderWidth: 2, // Ancho del borde
                    fill: true,
                    spacing: 10,

                };
                new Chart($grafica, {
                    type: 'doughnut', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            acciones,
                        ]
                    },
                    options: {
                       plugins:{
                           labels: {
                               render: 'percentage',
                               fontColor: ['white']
                           }
                       }
                    }
                });
            })();

            (async () => {
                // Llamar a nuestra API. Puedes usar cualquier librería para la llamada, yo uso fetch, que viene nativamente en JS
                const respuestaRaw = await fetch("get_data_chart_inversion.php");
                // Decodificar como JSON
                const respuesta = await respuestaRaw.json();
                // Ahora ya tenemos las etiquetas y datos dentro de "respuesta"
                // Obtener una referencia al elemento canvas del DOM
                const $grafica = document.querySelector("#grafica_inversion");
                const etiquetas = respuesta.etiquetas; // <- Aquí estamos pasando el valor traído usando AJAX
                // Podemos tener varios conjuntos de datos. Comencemos con uno
                const acciones = {
                    label: "inversión por municipio",
                    // Pasar los datos igualmente desde PHP
                    data: respuesta.datos, // <- Aquí estamos pasando el valor traído usando AJAX
                    backgroundColor: 'rgba(0, 110, 127, 0.8)', // Color de fondo
                    borderColor: 'rgba(0, 110, 127,0.9)', // Color del borde
                    borderWidth: 2, // Ancho del borde
                    fill: true,
                    spacing: 10,

                };
                new Chart($grafica, {
                    type: 'line', // Tipo de gráfica
                    data: {
                        labels: etiquetas,
                        datasets: [
                            acciones,
                        ]
                    },
                    options: {
                       plugins:{
                           labels: {
                               render: 'percentage',
                               fontColor: ['white']
                           }
                       }
                    }
                });
            })();
            </script>




    </main>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>

</html>