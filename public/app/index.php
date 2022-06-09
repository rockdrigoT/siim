<?php 
    require_once '../../src/utils.php';
    include  '../../src/verificaUser.php'; 
    $miUpp = $_SESSION['miupp'];
    $micargo = $_SESSION['cargo'];
                 
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

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <link href="../assets/css/com_ind.css" rel="stylesheet" />
    <link href="../assets/css/loader.css" rel="stylesheet" />
    <link href="../assets/css/dashboard.css" rel="stylesheet" />
    <title>SIIM_V1.2</title>

    <style>
    .TRTabla {
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        background-color: #6a0f49;
        color: white;
        text-align: center;
    }
    .cabezaTabla {
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        color: #6a0f49;
        text-align: center;
    }
    .mitabla{
        border-bottom: #6a0f49;
        border-bottom-width: thin;
        margin-top: 0px;
        margin-bottom: 0px;
    }
    .centrar{
        text-align: center;
    }

    h1,
    h2,
    h3,
    h4 {
        font-family: 'Roboto', sans-serif;
        font-weight: 500;
        color: #6a0f49;
    }
    </style>

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

    <?php include('../../templates/header.php') ?>


    <main class="col-md-12 ms-sm-auto col-lg-12 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <?php
            include ("../../src/classes/consultas.php");
            $con = new consulta();

            if(isset($_GET['municipio'])){
                $municipio = $_GET['municipio'];
                $nomMun =$con->encuentraMunicipio($municipio);
            while ($row1=mysqli_fetch_object($nomMun)){
                $nombreMunicipio = $row1->municipio;
            }
                echo "<h1 class='h2'>Ficha municipal: ".$nombreMunicipio."</h1>";
            }else{
                echo "<h1 class='h2'>Selecciona un municipio </h1>";
            }
            ?>
            <form action='index.php' method="get">
                <select class='select-control' name='municipio' id='municipio'>
                    <option>...selecciona municipio</option>
                    <?php
                     $listadoMunicipios =$con->listadoMunicipios();
                        while ($row=mysqli_fetch_object($listadoMunicipios)){
                            $clave_mun = $row->clave_mun;
                            $municipioNombre = $row->municipio;

                            echo "<option value='".$clave_mun."'>".$municipioNombre."</option>";
                        }
                    ?>
                </select>
                <input type="submit"  value="mostrar">
            </form>
            <a href="reporte_municipal_excel.php?municipio=<?= $municipio ?>&nombrempio=<?= $nombreMunicipio ?>" class='btn btn-primary'>exportar word</a>
            <!-- <a href="reporte_municipal_pdf.php?municipio=<?= $municipio ?>&nombrempio=<?= $nombreMunicipio ?>" target="_blank" class='btn btn-warning'>descargar PDF</a> -->

        </div>

        <?php
        if(isset($_GET['municipio'])){
            
        }else{
            exit;
        }
        ?>

        <div class="col-12 mb-4">
            <h4 class='mt-4' style='color:#6a0f49'>PROGRAMAS BIENESTAR 2022</h4>
            <table class="table table-bordered">
                <?php
       $cox = new consulta();
       $indicadoresBienestar = $cox -> indicadoresBienestar($municipio);
       while($row=mysqli_fetch_object($indicadoresBienestar)){
           $beneficiarios_por_hogar=$row->beneficiarios_por_hogar;
           $rk=$row->rk;
           
           $cobertura_adultos_mayores=$row->cobertura_adultos_mayores;
           $cobertura_discapacidad=$row->cobertura_discapacidad;
           echo "<tr style='font-size:1.3em'>
           <td colspan='2'>Beneficiarios por hogar:<span class='cabezaTabla'> ".number_format($beneficiarios_por_hogar,2)."</span></td>
           <td colspan='2'>Ranking municipal: <span class='cabezaTabla'>".$rk."</span></td>
           <td colspan='2'>Cobertura adultos mayores: <span class='cabezaTabla'>".(number_format($cobertura_adultos_mayores,2)*100)." %</span></td>
           <td>Cobertura discapacidad: <span class='cabezaTabla'>".(number_format($cobertura_discapacidad,2)*100)." %</span></td>
           </tr>";
       }
       ?>
            </table>
            <table class='table mitabla'>
                <?php
                 $conx = new consulta();
                 $programasBienestar = $conx -> lsBienestar($municipio);
                 while($rowB=mysqli_fetch_object($programasBienestar)){
                    $ben_total=$rowB->ben_total;
                    $ben_hombre=$rowB->ben_hombre;
                    $ben_mujeres=$rowB->ben_mujeres;
                    $monto_total=$rowB->monto_total;
                    $monto_hombre=$rowB->monto_hombre;
                    $monto_mujeres=$rowB->monto_mujeres;
                    $P0006_ben=$rowB->p0006_ben;
                    $P0006_hom=$rowB->p0006_hom;
                    $P0006_muj=$rowB->p0006_muj;
                    $P0006_monto=$rowB->p0006_monto;
                    $P0006_monto_hom=$rowB->p0006_monto_hom;
                    $P0006_monto_muj=$rowB->p0006_monto_muj;

                    $p0010_ben=$rowB->p0010_ben;
                    $p0010_hom=$rowB->p0010_hom;
                    $p0010_muj=$rowB->p0010_muj;
                    $p0010_monto=$rowB->p0010_monto;
                    $p0010_monto_hom=$rowB->p0010_monto_hom;
                    $p0010_monto_muj=$rowB->p0010_monto_muj;

                    $p0837_ben=$rowB->p0837_ben;
                    $p0837_hom=$rowB->p0837_hom;
                    $p0837_muj=$rowB->p0837_muj;
                    $p0837_monto=$rowB->p0837_monto;
                    $p0837_monto_hom=$rowB->p0837_monto_hom;
                    $p0837_monto_muj=$rowB->p0837_monto_muj;

                    $p0838_ben=$rowB->p0838_ben;
                    $p0838_hom=$rowB->p0838_hom;
                    $p0838_muj=$rowB->p0838_muj;
                    $p0838_monto=$rowB->p0838_monto;
                    $p0838_monto_hom=$rowB->p0838_monto_hom;
                    $p0838_monto_muj=$rowB->p0838_monto_muj;

                    $p0844_ben=$rowB->p0844_ben;
                    $p0844_hom=$rowB->p0844_hom;
                    $p0844_muj=$rowB->p0844_muj;
                    $p0844_monto=$rowB->p0844_monto;
                    $p0844_monto_hom=$rowB->p0844_monto_hom;
                    $p0844_monto_muj=$rowB->p0844_monto_muj;

                    $p0846_ben=$rowB->p0846_ben;
                    $p0846_hom=$rowB->p0846_hom;
                    $p0846_muj=$rowB->p0846_muj;
                    $p0846_monto=$rowB->p0846_monto;
                    $p0846_monto_hom=$rowB->p0846_monto_hom;
                    $p0846_monto_muj=$rowB->p0846_monto_muj;

                    $p0848_ben=$rowB->p0848_ben;
                    $p0848_hom=$rowB->p0848_hom;
                    $p0848_muj=$rowB->p0848_muj;
                    $p0848_monto=$rowB->p0848_monto;
                    $p0848_monto_hom=$rowB->p0848_monto_hom;
                    $p0848_monto_muj=$rowB->p0848_monto_muj;

                    $p0850_ben=$rowB->p0850_ben;
                    $p0850_hom=$rowB->p0850_hom;
                    $p0850_muj=$rowB->p0850_muj;
                    $p0850_monto=$rowB->p0850_monto;
                    $p0850_monto_hom=$rowB->p0850_monto_hom;
                    $p0850_monto_muj=$rowB->p0850_monto_muj;

                    $p0852_ben=$rowB->p0852_ben;
                    $p0852_hom=$rowB->p0852_hom;
                    $p0852_muj=$rowB->p0852_muj;
                    $p0852_monto=$rowB->p0852_monto;
                    $p0852_monto_hom=$rowB->p0852_monto_hom;
                    $p0852_monto_muj=$rowB->p0852_monto_muj;

                    $p0858_ben=$rowB->p0858_ben;
                    $p0858_hom=$rowB->p0858_hom;
                    $p0858_muj=$rowB->p0858_muj;
                    $p0858_monto=$rowB->p0858_monto;
                    $p0858_monto_hom=$rowB->p0858_monto_hom;
                    $p0858_monto_muj=$rowB->p0858_monto_muj;

                    $p0893_ben=$rowB->p0893_ben;
                    $p0893_hom=$rowB->p0893_hom;
                    $p0893_muj=$rowB->p0893_muj;
                    $p0893_monto=$rowB->p0893_monto;
                    $p0893_monto_hom=$rowB->p0893_monto_hom;
                    $p0893_monto_muj=$rowB->p0893_monto_muj;

                    $p0923_ben=$rowB->p0923_ben;
                    $p0923_hom=$rowB->p0923_hom;
                    $p0923_muj=$rowB->p0923_muj;
                    $p0923_monto=$rowB->p0923_monto;
                    $p0923_monto_hom=$rowB->p0923_monto_hom;
                    $p0923_monto_muj=$rowB->p0923_monto_muj;

                    $p0929_ben=$rowB->p0929_ben;
                    $p0929_hom=$rowB->p0929_hom;
                    $p0929_muj=$rowB->p0929_muj;
                    $p0929_monto=$rowB->p0929_monto;
                    $p0929_monto_hom=$rowB->p0929_monto_hom;
                    $p0929_monto_muj=$rowB->p0929_monto_muj;

                    $p0938_ben=$rowB->p0938_ben;
                    $p0938_hom=$rowB->p0938_hom;
                    $p0938_muj=$rowB->p0938_muj;
                    $p0938_monto=$rowB->p0938_monto;
                    $p0938_monto_hom=$rowB->p0938_monto_hom;
                    $p0938_monto_muj=$rowB->p0938_monto_muj;

                    $pS072_ben=$rowB->pS072_ben;
                    $pS072_hom=$rowB->pS072_hom;
                    $pS072_muj=$rowB->pS072_muj;
                    $pS072_monto=$rowB->pS072_monto;
                    $pS072_monto_hom=$rowB->pS072_monto_hom;
                    $pS072_monto_muj=$rowB->pS072_monto_muj;

                    $pS174_ben=$rowB->pS174_ben;
                    $pS174_hom=$rowB->pS174_hom;
                    $pS174_muj=$rowB->pS174_muj;
                    $pS174_monto=$rowB->pS174_monto;
                    $pS174_monto_hom=$rowB->pS174_monto_hom;
                    $pS174_monto_muj=$rowB->pS174_monto_muj;

                    $pS176_ben=$rowB->pS176_ben;
                    $pS176_hom=$rowB->pS176_hom;
                    $pS176_muj=$rowB->pS176_muj;
                    $pS176_monto=$rowB->pS176_monto;
                    $pS176_monto_hom=$rowB->pS176_monto_hom;
                    $pS176_monto_muj=$rowB->pS176_monto_muj;

                    $pS243_ben=$rowB->pS243_ben;
                    $pS243_hom=$rowB->pS243_hom;
                    $pS243_muj=$rowB->pS243_muj;
                    $pS243_monto=$rowB->pS243_monto;
                    $pS243_monto_hom=$rowB->pS243_monto_hom;
                    $pS243_monto_muj=$rowB->pS243_monto_muj;

                    $pS283_ben=$rowB->pS283_ben;
                    $pS283_hom=$rowB->pS283_hom;
                    $pS283_muj=$rowB->pS283_muj;
                    $pS283_monto=$rowB->pS283_monto;
                    $pS283_monto_hom=$rowB->pS283_monto_hom;
                    $pS283_monto_muj=$rowB->pS283_monto_muj;

                    $pS285_ben=$rowB->pS285_ben;
                    $pS285_hom=$rowB->pS285_hom;
                    $pS285_muj=$rowB->pS285_muj;
                    $pS285_monto=$rowB->pS285_monto;
                    $pS285_monto_hom=$rowB->pS285_monto_hom;
                    $pS285_monto_muj=$rowB->pS285_monto_muj;

                    $pS286_ben=$rowB->pS286_ben;
                    $pS286_hom=$rowB->pS286_hom;
                    $pS286_muj=$rowB->pS286_muj;
                    $pS286_monto=$rowB->pS286_monto;
                    $pS286_monto_hom=$rowB->pS286_monto_hom;
                    $pS286_monto_muj=$rowB->pS286_monto_muj;

                    $pS287_ben=$rowB->pS287_ben;
                    $pS287_hom=$rowB->pS287_hom;
                    $pS287_muj=$rowB->pS287_muj;
                    $pS287_monto=$rowB->pS287_monto;
                    $pS287_monto_hom=$rowB->pS287_monto_hom;
                    $pS287_monto_muj=$rowB->pS287_monto_muj;

                    $pS290_ben=$rowB->pS290_ben;
                    $pS290_hom=$rowB->pS290_hom;
                    $pS290_muj=$rowB->pS290_muj;
                    $pS290_monto=$rowB->pS290_monto;
                    $pS290_monto_hom=$rowB->pS290_monto_hom;
                    $pS290_monto_muj=$rowB->pS290_monto_muj;

                    $pS292_ben=$rowB->pS292_ben;
                    $pS292_hom=$rowB->pS292_hom;
                    $pS292_muj=$rowB->pS292_muj;
                    $pS292_monto=$rowB->pS292_monto;
                    $pS292_monto_hom=$rowB->pS292_monto_hom;
                    $pS292_monto_muj=$rowB->pS292_monto_muj;

                    $pS311_ben=$rowB->pS311_ben;
                    $pS311_hom=$rowB->pS311_hom;
                    $pS311_muj=$rowB->pS311_muj;
                    $pS311_monto=$rowB->pS311_monto;
                    $pS311_monto_hom=$rowB->pS311_monto_hom;
                    $pS311_monto_muj=$rowB->pS311_monto_muj;

                    $pU021_ben=$rowB->pU021_ben;
                    $pU021_hom=$rowB->pU021_hom;
                    $pU021_muj=$rowB->pU021_muj;
                    $pU021_monto=$rowB->pU021_monto;
                    $pU021_monto_hom=$rowB->pU021_monto_hom;
                    $pU021_monto_muj=$rowB->pU021_monto_muj;

                    echo "
                    <thead>
                    <tr class='TRTabla'>
                    <td></td>
                    <td>Beneficiarios</td>
                    <td>Hombres</td>
                    <td>Mujeres</td>
                    <td>Monto total</td>
                    <td>Monto hombres</td>
                    <td>Monto mujeres</td>
                    </tr>
                    </thead>
                    <tr class='cabezaTabla'>
                    <td>Total municipal</td>
                    <td>".number_format($ben_total)."</td>
                    <td>".number_format($ben_hombre)."</td>
                    <td>".number_format($ben_mujeres)."</td>
                    <td>$".number_format($monto_total)."</td>
                    <td>$".number_format($monto_hombre)."</td>
                    <td>$".number_format($monto_mujeres)."</td>
                    </tr>";
                   
                    if (!$P0006_ben == 0){
                    echo "<tr>
                    <td>Bienestar de las niñas, niños, adolescentes y jóvenes en orfandad materna</td>
                    <td class='centrar'>".number_format($P0006_ben)."</td>
                    <td class='centrar'>".number_format($P0006_hom)."</td>
                    <td class='centrar'>".number_format($P0006_muj)."</td>
                    <td class='centrar'>$".number_format($P0006_monto)."</td>
                    <td class='centrar'>$".number_format($P0006_monto_hom)."</td>
                    <td class='centrar'>$".number_format($P0006_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0010_ben == 0){
                    echo "<tr>
                    <td>Microcréditos para el Bienestar</td>
                    <td class='centrar'>".number_format($p0010_ben)."</td>
                    <td class='centrar'>".number_format($p0010_hom)."</td>
                    <td class='centrar'>".number_format($p0010_muj)."</td>
                    <td class='centrar'>$".number_format($p0010_monto)."</td>
                    <td class='centrar'>$".number_format($p0010_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0010_monto_muj)."</td>
                    </tr>";
                    }else{}
                    
                    if (!$p0837_ben == 0){
                    echo"<tr>
                    <td>PMU (INSUS) Regularización y Certeza Jurídica</td>
                    <td class='centrar'>".number_format($p0837_ben)."</td>
                    <td class='centrar'>".number_format($p0837_hom)."</td>
                    <td class='centrar'>".number_format($p0837_muj)."</td>
                    <td class='centrar'>$".number_format($p0837_monto)."</td>
                    <td class='centrar'>$".number_format($p0837_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0837_monto_muj)."</td>
                    </tr>";
                    }else{
                    }

                    if (!$p0838_ben == 0){
                    echo"<tr>
                    <td>PMU (CONAVI) Vivienda en Ámbito Urbano</td>
                    <td class='centrar'>".number_format($p0838_ben)."</td>
                    <td class='centrar'>".number_format($p0838_hom)."</td>
                    <td class='centrar'>".number_format($p0838_muj)."</td>
                    <td class='centrar'>$".number_format($p0838_monto)."</td>
                    <td class='centrar'>$".number_format($p0838_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0838_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0844_ben == 0){
                    echo "<tr>
                    <td>Producción para el Bienestar Pequeños y Medianos Productores</td>
                    <td class='centrar'>".number_format($p0844_ben)."</td>
                    <td class='centrar'>".number_format($p0844_hom)."</td>
                    <td class='centrar'>".number_format($p0844_muj)."</td>
                    <td class='centrar'>$".number_format($p0844_monto)."</td>
                    <td class='centrar'>$".number_format($p0844_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0844_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0846_ben == 0){
                    echo "<tr>
                    <td>Producción para el Bienestar Pequeños Productores (Ex PIMAF)</td>
                    <td class='centrar'>".number_format($p0846_ben)."</td>
                    <td class='centrar'>".number_format($p0846_hom)."</td>
                    <td class='centrar'>".number_format($p0846_muj)."</td>
                    <td class='centrar'>$".number_format($p0846_monto)."</td>
                    <td class='centrar'>$".number_format($p0846_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0846_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0848_ben == 0){
                    echo "<tr>
                    <td>Producción para el Bienestar Productores Indígenas</td>
                    <td class='centrar'>".number_format($p0848_ben)."</td>
                    <td class='centrar'>".number_format($p0848_hom)."</td>
                    <td class='centrar'>".number_format($p0848_muj)."</td>
                    <td class='centrar'>$".number_format($p0848_monto)."</td>
                    <td class='centrar'>$".number_format($p0848_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0848_monto_muj)."</td>
                    </tr>";
                    }else{}
                    
                    if (!$p0850_ben == 0){
                    echo "<tr>
                    <td>Producción para el Bienestar Productores Caña de Azúcar</td>
                    <td class='centrar'>".number_format($p0850_ben)."</td>
                    <td class='centrar'>".number_format($p0850_hom)."</td>
                    <td class='centrar'>".number_format($p0850_muj)."</td>
                    <td class='centrar'>$".number_format($p0850_monto)."</td>
                    <td class='centrar'>$".number_format($p0850_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0850_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0852_ben == 0){
                    echo "<tr>
                    <td>Producción para el Bienestar Productores de Café</td>
                    <td class='centrar'>".number_format($p0852_ben)."</td>
                    <td class='centrar'>".number_format($p0852_hom)."</td>
                    <td class='centrar'>".number_format($p0852_muj)."</td>
                    <td class='centrar'>$".number_format($p0852_monto)."</td>
                    <td class='centrar'>$".number_format($p0852_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0852_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0858_ben == 0){
                    echo "<tr>
                    <td>Programa Nacional de Reconstrucción Reconstrucción (Vivienda)</td>
                    <td class='centrar'>".number_format($p0858_ben)."</td>
                    <td class='centrar'>".number_format($p0858_hom)."</td>
                    <td class='centrar'>".number_format($p0858_muj)."</td>
                    <td class='centrar'>$".number_format($p0858_monto)."</td>
                    <td class='centrar'>$".number_format($p0858_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0858_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0893_ben == 0){
                    echo "<tr>
                    <td>Jóvenes Construyendo el Futuro</td>
                    <td class='centrar'>".number_format($p0893_ben)."</td>
                    <td class='centrar'>".number_format($p0893_hom)."</td>
                    <td class='centrar'>".number_format($p0893_muj)."</td>
                    <td class='centrar'>$".number_format($p0893_monto)."</td>
                    <td class='centrar'>$".number_format($p0893_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0893_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0923_ben == 0){
                    echo "<tr>
                    <td>Apoyo para el Bienestar de Pescadores y Acuicultores</td>
                    <td class='centrar'>".number_format($p0923_ben)."</td>
                    <td class='centrar'>".number_format($p0923_hom)."</td>
                    <td class='centrar'>".number_format($p0923_muj)."</td>
                    <td class='centrar'>$".number_format($p0923_monto)."</td>
                    <td class='centrar'>$".number_format($p0923_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0923_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0929_ben == 0){
                    echo "<tr>
                    <td>Bienestar de las Personas en Emergencia Social o Natural</td>
                    <td class='centrar'>".number_format($p0929_ben)."</td>
                    <td class='centrar'>".number_format($p0929_hom)."</td>
                    <td class='centrar'>".number_format($p0929_muj)."</td>
                    <td class='centrar'>$".number_format($p0929_monto)."</td>
                    <td class='centrar'>$".number_format($p0929_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0929_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$p0938_ben == 0){
                    echo "<tr>
                    <td>Programa Emergente de Vivienda</td>
                    <td class='centrar'>".number_format($p0938_ben)."</td>
                    <td class='centrar'>".number_format($p0938_hom)."</td>
                    <td class='centrar'>".number_format($p0938_muj)."</td>
                    <td class='centrar'>$".number_format($p0938_monto)."</td>
                    <td class='centrar'>$".number_format($p0938_monto_hom)."</td>
                    <td class='centrar'>$".number_format($p0938_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS072_ben == 0){
                    echo "<tr>
                    <td>Becas de Educación Básica para el Bienestar Benito Juárez</td>
                    <td class='centrar'>".number_format($pS072_ben)."</td>
                    <td class='centrar'>".number_format($pS072_hom)."</td>
                    <td class='centrar'>".number_format($pS072_muj)."</td>
                    <td class='centrar'>$".number_format($pS072_monto)."</td>
                    <td class='centrar'>$".number_format($pS072_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS072_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS174_ben == 0){
                    echo "<tr>
                    <td>Bienestar de las Niñas y Niños, Hijos de Madres Trabajadoras</td>
                    <td class='centrar'>".number_format($pS174_ben)."</td>
                    <td class='centrar'>".number_format($pS174_hom)."</td>
                    <td class='centrar'>".number_format($pS174_muj)."</td>
                    <td class='centrar'>$".number_format($pS174_monto)."</td>
                    <td class='centrar'>$".number_format($pS174_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS174_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS176_ben == 0){
                    echo "<tr>
                    <td>Pensión para el Bienestar de las Personas Adultas Mayores</td>
                    <td class='centrar'>".number_format($pS176_ben)."</td>
                    <td class='centrar'>".number_format($pS176_hom)."</td>
                    <td class='centrar'>".number_format($pS176_muj)."</td>
                    <td class='centrar'>$".number_format($pS176_monto)."</td>
                    <td class='centrar'>$".number_format($pS176_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS176_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS243_ben == 0){
                    echo "<tr>
                    <td>Becas Elisa Acuña</td>
                    <td class='centrar'>".number_format($pS243_ben)."</td>
                    <td class='centrar'>".number_format($pS243_hom)."</td>
                    <td class='centrar'>".number_format($pS243_muj)."</td>
                    <td class='centrar'>$".number_format($pS243_monto)."</td>
                    <td class='centrar'>$".number_format($pS243_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS243_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS283_ben == 0){
                    echo "<tr>
                    <td>Jóvenes Escribiendo el Futuro</td>
                    <td class='centrar'>".number_format($pS283_ben)."</td>
                    <td class='centrar'>".number_format($pS283_hom)."</td>
                    <td class='centrar'>".number_format($pS283_muj)."</td>
                    <td class='centrar'>$".number_format($pS283_monto)."</td>
                    <td class='centrar'>$".number_format($pS283_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS283_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS285_ben == 0){
                    echo "<tr>
                    <td>Microcréditos para el Bienestar Modalidad Consolidación</td>
                    <td class='centrar'>".number_format($pS285_ben)."</td>
                    <td class='centrar'>".number_format($pS285_hom)."</td>
                    <td class='centrar'>".number_format($pS285_muj)."</td>
                    <td class='centrar'>$".number_format($pS285_monto)."</td>
                    <td class='centrar'>$".number_format($pS285_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS285_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS286_ben == 0){
                    echo "<tr>
                    <td>Pensión para el Bienestar de las Personas con Discapacidad Permanente</td>
                    <td class='centrar'>".number_format($pS286_ben)."</td>
                    <td class='centrar'>".number_format($pS286_hom)."</td>
                    <td class='centrar'>".number_format($pS286_muj)."</td>
                    <td class='centrar'>$".number_format($pS286_monto)."</td>
                    <td class='centrar'>$".number_format($pS286_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS286_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS287_ben == 0){
                    echo "<tr>
                    <td>Sembrando Vida</td>
                    <td class='centrar'>".number_format($pS287_ben)."</td>
                    <td class='centrar'>".number_format($pS287_hom)."</td>
                    <td class='centrar'>".number_format($pS287_muj)."</td>
                    <td class='centrar'>$".number_format($pS287_monto)."</td>
                    <td class='centrar'>$".number_format($pS287_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS287_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS290_ben == 0){
                    echo "<tr>
                    <td>Precios de Garantía a Productos Alimentarios Básicos</td>
                    <td class='centrar'>".number_format($pS290_ben)."</td>
                    <td class='centrar'>".number_format($pS290_hom)."</td>
                    <td class='centrar'>".number_format($pS290_muj)."</td>
                    <td class='centrar'>$".number_format($pS290_monto)."</td>
                    <td class='centrar'>$".number_format($pS290_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS290_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS292_ben == 0){
                    echo "<tr>
                    <td>Fertilizantes</td>
                    <td class='centrar'>".number_format($pS292_ben)."</td>
                    <td class='centrar'>".number_format($pS292_hom)."</td>
                    <td class='centrar'>".number_format($pS292_muj)."</td>
                    <td class='centrar'>$".number_format($pS292_monto)."</td>
                    <td class='centrar'>$".number_format($pS292_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS292_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pS311_ben == 0){
                    echo "<tr>
                    <td>Beca Universal para Estudiantes de Educación Media Superior Benito Juárez</td>
                    <td class='centrar'>".number_format($pS311_ben)."</td>
                    <td class='centrar'>".number_format($pS311_hom)."</td>
                    <td class='centrar'>".number_format($pS311_muj)."</td>
                    <td class='centrar'>$".number_format($pS311_monto)."</td>
                    <td class='centrar'>$".number_format($pS311_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pS311_monto_muj)."</td>
                    </tr>";
                    }else{}

                    if (!$pU021_ben == 0){
                    echo "<tr>
                    <td>Crédito Ganadero a la Palabra</td>
                    <td class='centrar'>".number_format($pU021_ben)."</td>
                    <td class='centrar'>".number_format($pU021_hom)."</td>
                    <td class='centrar'>".number_format($pU021_muj)."</td>
                    <td class='centrar'>$".number_format($pU021_monto)."</td>
                    <td class='centrar'>$".number_format($pU021_monto_hom)."</td>
                    <td class='centrar'>$".number_format($pU021_monto_muj)."</td>
                    </tr>";
                    }else{}
                 }
                ?>
            </table>
            <br>
            <h4>FAEISPUM 2022</h4>
            <table class="table table-bordered">
                <?php 
            $lsFAEISPUM =$con->lsFaeispum($municipio);
            while ($row1=mysqli_fetch_object($lsFAEISPUM)){
                $total_proyectos = $row1->total_proyectos;
                $total_autorizado = $row1->total_autorizado;
                $asignado = $row1->asignado;
                $saldo = $row1->saldo;
                $ministrado = $row1->ministrado;
                $proyectos_revision = $row1->proyectos_revision;
                $monto_revision = $row1->monto_revision;
                
                echo "
                <thead>
                <tr class='TRTabla'>
                <td>Proyectos</td>
                <td>Asignado</td>
                <td>Autorizado</td>
                <td>Saldo actual</td>
                <td>Ministrado</td>
                <td>En revisión</td>
                <td>Monto en revisión</td>
                </tr>
                </thead>
                <tr class='cabezaTabla'>
                <td>".number_format($total_proyectos)."</td>
                <td>$".number_format($asignado)."</td>
                <td>$".number_format($total_autorizado)."</td>
                <td>$".number_format($saldo)."</td>
                <td>$".number_format($ministrado)."</td>
                <td>".number_format($proyectos_revision)."</td>
                <td>$".number_format($monto_revision)."</td>
                </tr>";
                if (!$total_proyectos == 0){

                    echo "</table> <br>
                    <table class='table' style='font-family: Arial, Helvetica, sans-serif'>
                    <thead>
                    <tr class='TRTabla'>
                    <td>ID Proyecto</td>
                    <td colspan='4'>Descripción</td>
                    <td>Estatus</td>
                    <td>Monto</td>
                    </tr>
                    </thead>
                    ";
                    
                    $proyectosFaeispum =$con->proyectosFaeispum($municipio);
                    while ($row=mysqli_fetch_object($proyectosFaeispum)){
                        $Proyecto = $row->Proyecto;
                        $ID_proyecto = $row->ID_proyecto;
                        $Monto = $row->Monto;
                        $estatus = $row->estatus;
                        echo "<tr>
                        <td>".$ID_proyecto."</td>
                        <td colspan='4'>".mb_strtolower($Proyecto)."</td>
                        <td>".$estatus."</td>
                        <td>$".number_format($Monto,0)."</td>
                        </tr>";
                    }

                }else{
                    echo "</table>";
                }
            }
            
            
            ?>
            </table>
            <br>

            <h4>OBRAS SCOP 2022</h4>
            <div><h4>
            <?php
            
            $contarAcciones =$con->contarAcciones($municipio);
            while ($row=mysqli_fetch_object($contarAcciones)){
                $numeroAcciones = $row->numeroAcciones;
                echo number_format($numeroAcciones)." acciones con una inversión total de ";
            }

            $montoAcciones =$con->sumarAcciones($municipio);
            while ($row=mysqli_fetch_object($montoAcciones)){
                $totalMontoAcciones = $row->totalMontoAcciones;
                echo "$".number_format($totalMontoAcciones);
            }
            ?>
            </h4>
            </div>
            <table class="table table-bordered">
            <thead>
                <tr class='TRTabla'>
                <td>UPP</td>
                <td>Localidad</td>
                <td>Acción</td>
                <td>Descripción</td>
                <td>Monto</td>
                </tr>
                </thead>
                <?php 
            $lsAcciones =$con->acciones($municipio);
            while ($row1=mysqli_fetch_object($lsAcciones)){
                $localidad = $row1->localidad;
                $upp = $row1->upp;
                $accion = $row1->accion;
                $descripcion = $row1->descripcion;
                $monto = $row1->monto;
                
                echo "
                <tr>
                <td>".$upp."</td>
                <td>".$localidad."</td>
                <td>".$accion."</td>
                <td>".$descripcion."</td>
                <td>$".number_format($monto)."</td>
                </tr>";
               
            }            
            ?>
            </table>
            <br>

            <h4 class="mt-4">FORTAPAZ 2022</h4>
            <table class="table table-bordered">
                <?php
            $lsFortapaz =$con->lsFortapaz($municipio);
            while ($row=mysqli_fetch_object($lsFortapaz)){
                $monto_total=$row->monto_total;
                $estatal=$row->estatal;
                $aportacion=$row->aportacion;
                $bloque=$row->bloque;
                echo "
                <thead>
                <tr class='TRTabla'>
                <td colspan='2'>Monto asignado</td>
                <td colspan='2'>Estado</td>
                <td>Municipio</td>
                <td>Bloque</td>
                <td>Monto autorizado</td>
                </tr>
                </thead>
                <tr class='cabezaTabla'>
                <td colspan='2'>$".number_format($monto_total)."</td>
                <td colspan='2'>$".number_format($estatal)."</td>
                <td>$".number_format($aportacion)."</td>
                <td>".$bloque." bloque</td>
                <td>";
                $anexoFortapaz = $con -> fortapaz_anexos($municipio);
                while($row=mysqli_fetch_object($anexoFortapaz)){
                    $p1e =$row->p1e;
                    $p1m =$row->p1m;
                    $p2e =$row->p2e;
                    $p2m =$row->p2m;
                    $p3e =$row->p3e;
                    $p3m =$row->p3m;
                    $p4e =$row->p4e;
                    $p4m =$row->p4m;
                    $p5e =$row->p5e;
                    $p5m =$row->p5m;
                    $p6e =$row->p6e;
                    $p6m =$row->p6m;

                    $totalFortapazAutorizado = ($p1e+$p1m+$p2e+$p2m+$p3e+$p3m+$p4e+$p4m+$p5e+$p5m+$p6e+$p6m);                    
                }
                if (isset($totalFortapazAutorizado)){
                    
                }else{
                    $totalFortapazAutorizado = "0";
                }

                echo "$".number_format($totalFortapazAutorizado,0)."</td>
                </tr>";
            };
            ?>
            </table>
            <br>


            <?php
            if($totalFortapazAutorizado == '0'){
                
            } else {
                ?>
                 <table class="table" style='font-family: Arial, Helvetica, sans-serif; font-size:1em'>
                <thead>
                    <tr class='TRTabla'>
                        <td colspan='4'>Programa con prioridad nacional</td>
                        <td>Estatal</td>
                        <td>Municipio / Comunidad</td>
                        <td>Inversión total</td>
                    </tr>
                </thead>
                <?php
                $anexoFortapaz = $con -> fortapaz_anexos($municipio);
                while($row=mysqli_fetch_object($anexoFortapaz)){
                    $p1e =$row->p1e;
                    $p1m =$row->p1m;
                    $p2e =$row->p2e;
                    $p2m =$row->p2m;
                    $p3e =$row->p3e;
                    $p3m =$row->p3m;
                    $p4e =$row->p4e;
                    $p4m =$row->p4m;
                    $p5e =$row->p5e;
                    $p5m =$row->p5m;
                    $p6e =$row->p6e;
                    $p6m =$row->p6m;
                    
                    echo "<tr>
                    <td colspan='4'>I.Impulso al modelo nacional de policía y justicia cívica</td>
                    <td>$".number_format($p1e,2)."</td>
                    <td>$".number_format($p1m,2)."</td>
                    <td>$".number_format(($p1e+$p1m),2)."</td>
                    </tr>
                    <tr>
                    <td colspan='4'>II.Profesionalización, Certificación y Capacitación de los elementos Policiales y las Instituciones de Seguridad Pública</td>
                    <td>$".number_format($p2e,2)."</td>
                    <td>$".number_format($p2m,2)."</td>
                    <td>$".number_format(($p2e+$p2m),2)."</td>
                    </tr>
                    <tr>
                    <td colspan='4'>III.Equipamiento e infraestructura de los elementos policiales y las instituticones de Seguridad Pública</td>
                    <td>$".number_format($p3e,2)."</td>
                    <td>$".number_format($p3m,2)."</td>
                    <td>$".number_format(($p3e+$p3m),2)."</td>
                    </tr>
                    <tr>
                    <td colspan='4'>IV.Prevención Social de la Violencia y la Delincuencia con Participación Ciudadana</td>
                    <td>$".number_format($p4e,2)."</td>
                    <td>$".number_format($p4m,2)."</td>
                    <td>$".number_format(($p4e+$p4m),2)."</td>
                    </tr>
                    <tr>
                    <td colspan='4'>V.Fortalecimiento del Sistema Penitenciario Nacional y de Ejecución de Medidas para Adolescentes</td>
                    <td>$".number_format($p5e,2)."</td>
                    <td>$".number_format($p5m,2)."</td>
                    <td>$".number_format(($p5e+$p5m),2)."</td>
                    </tr>
                    <tr>
                    <td colspan='4'>VI.Sistema Nacional de Información</td>
                    <td>$".number_format($p6e,2)."</td>
                    <td>$".number_format($p6m,2)."</td>
                    <td>$".number_format(($p6e+$p6m),2)."</td>
                    </tr>
                    ";
                }
                ?>
            </table>
            <br>
            <?php
            }
            ?>



            <h4 class="mt-4">INCIDENCIA DELICTIVA Y HOMICIDIO DOLOSO</h4>
            <table class="table table-bordered">
                <thead>
                    <tr class='TRTabla'>
                        <td colspan='9' style='background-color:#ffc3d0; color:#6a0f49'>Delitos Enero-Abril 2022</td>
                        <td colspan='2'>Delitos Alto Impacto</td>
                    </tr>
                    <tr class='TRTabla'>
                        <td>Tipo</td>
                        <td>Homicidio</td>
                        <td>Secuestro</td>
                        <td>Extorsión</td>
                        <td>Feminicidio</td>
                        <td>Robo vehículo</td>
                        <td>Robo casa-habitación</td>
                        <td>Robo transeunte</td>
                        <td>Robo negocios</td>
                        <td>2022</td>
                        <td>2021</td>
                    </tr>
                </thead>
                <?php

                $indel = $con -> seguridad($municipio);
                while($row=mysqli_fetch_object($indel)){
                    $carpeta_homicidio=$row->carpeta_homicidio;
                    $carpeta_secuestro =$row->carpeta_secuestro;
                    $carpeta_extorsion =$row->carpeta_extorsion;
                    $carpeta_feminicidio =$row->carpeta_feminicidio;
                    $carpeta_robo_vehiculo =$row->carpeta_robo_vehiculo;
                    $carpeta_robo_casa_habitacion =$row->carpeta_robo_casa_habitacion;
                    $carpeta_robo_transeunte =$row->carpeta_robo_transeunte;
                    $carpeta_robo_negocio =$row->carpeta_robo_negocio;
                    $carpeta_alto_imapacto =$row->carpeta_alto_imapacto;
                    $carpetas_dai_2021 =$row->carpetas_dai_2021;
                    
                    $tasa_homicidio =$row->tasa_homicidio;
                    $tasa_secuestro =$row->tasa_secuestro;
                    $tasa_extorsion =$row->tasa_extorsion;
                    $tasa_feminicidio =$row->tasa_feminicidio;
                    $tasa_robo_vehiculo =$row->tasa_robo_vehiculo;
                    $tasa_robo_casa_habitacion =$row->tasa_robo_casa_habitacion;
                    $tasa_robo_transeunte =$row->tasa_robo_transeunte;
                    $tasa_robo_negocio =$row->tasa_robo_negocio;
                    $tasa_dai_2022 =$row->tasa_dai_2022;
                    $tasa_dai_2021 =$row->tasa_dai_2021;

                    echo "
                    <tr class='cabezaTabla'>
                    <td> Carpetas </td>
                    <td>".$carpeta_homicidio."</td>
                    <td>".$carpeta_secuestro."</td>
                    <td>".$carpeta_extorsion."</td>
                    <td>".$carpeta_feminicidio."</td>
                    <td>".$carpeta_robo_vehiculo."</td>
                    <td>".$carpeta_robo_casa_habitacion."</td>
                    <td>".$carpeta_robo_transeunte."</td>
                    <td>".$carpeta_robo_negocio."</td>
                    <td>".$carpeta_alto_imapacto."</td>
                    <td>".$carpetas_dai_2021."</td>
                    </tr>

                    <tr class='cabezaTabla'>
                    <td> Tasa (100 mil hab) </td>
                    <td>".$tasa_homicidio."</td>
                    <td>".$tasa_secuestro."</td>
                    <td>".$tasa_extorsion."</td>
                    <td>".$tasa_feminicidio."</td>
                    <td>".$tasa_robo_vehiculo."</td>
                    <td>".$tasa_robo_casa_habitacion."</td>
                    <td>".$tasa_robo_transeunte."</td>
                    <td>".$tasa_robo_negocio."</td>
                    <td>".$tasa_dai_2022."</td>
                    <td>".$tasa_dai_2021."</td>
                    </tr>
                    ";
                }
                echo "
                </table>";
                ?>

            </table>
            <br>

            <h4 class="mt-4">PROBREZA CONEVAL 2020</h4>
            <table class="table table-bordered">
                <thead>
                    <tr class='TRTabla'>
                        <td>Indicador</td>
                        <td>Porcentaje población</td>
                        <td>Ranking municipal</td>
                        <td></td>
                        <td>Indicador</td>
                        <td>Porcentaje población</td>
                        <td>Ranking municipal</td>
                    </tr>
                </thead>
                <?php
            $coneval =$con->coneval($municipio);
            while ($row=mysqli_fetch_object($coneval)){
                $pobreza=$row->pobreza;
                $ranking1=$row->ranking1;
                $pobreza_extrema=$row->pobreza_extrema;
                $ranking2=$row->ranking2;
                $pobreza_moderada=$row->pobreza_moderada;
                $ranking3=$row->ranking3;
                $vulnerable_por_carencia_social =$row->vulnerable_por_carencia_social ;
                $ranking4=$row->ranking4;
                $vulnerable_por_ingreso=$row->vulnerable_por_ingreso ;
                $ranking5=$row->ranking5;
                $no_pobre_y_no_vulnerable=$row->no_pobre_y_no_vulnerable ;
                $ranking6=$row->ranking6;
                $rezago_educativo =$row->rezago_educativo;
                $ranking7=$row->ranking7;
                $servicios_de_salud=$row->servicios_de_salud;
                $ranking8=$row->ranking8;
                $seguridad_social=$row->seguridad_social;
                $ranking9=$row->ranking9;
                $calidad_y_espacios=$row->calidad_y_espacios;
                $ranking10=$row->ranking10;
                $servicios_basicos_en_la_vivienda=$row->servicios_basicos_en_la_vivienda;
                $ranking11=$row->ranking11;
                $acceso_a_la_alimentacion=$row->acceso_a_la_alimentacion;
                $ranking12=$row->ranking12;
                $con_al_menos_una_carencia=$row->con_al_menos_una_carencia;
                $ranking13=$row->ranking13;
                $tres_o_mas_carencias=$row->tres_o_mas_carencias;
                $ranking14=$row->ranking14;
                $inferior_a_linea_de_pobreza_por_ingresos=$row->inferior_a_linea_de_pobreza_por_ingresos;
                $ranking15=$row->ranking15;
                $linea_pobreza_extrema_por_ingresos=$row->linea_pobreza_extrema_por_ingresos;
                $ranking16=$row->ranking16;

                echo "
                <tr>
                <td class='cabezaTabla'>Pobreza</td>
                <td>".number_format($pobreza)."%</td>
                <td>".number_format($ranking1)."</td>
                <td></td>
                <td class='cabezaTabla'>Pobreza extrema</td>
                <td>".number_format($pobreza_extrema)."%</td>
                <td>".number_format($ranking2)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Pobreza moderada</td>
                <td>".number_format($pobreza_moderada)."%</td>
                <td>".number_format($ranking3)."</td>
                <td></td>
                <td class='cabezaTabla'>Vulnerable por carencia social</td>
                <td>".number_format($vulnerable_por_carencia_social )."%</td>
                <td>".number_format($ranking4)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Vulnerable por ingreso</td>
                <td>".number_format($vulnerable_por_ingreso)."%</td>
                <td>".number_format($ranking5)."</td>
                <td></td>
                <td class='cabezaTabla'>No pobre y no vulnerable</td>
                <td>".number_format($no_pobre_y_no_vulnerable)."%</td>
                <td>".number_format($ranking6)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Rezago educativo</td>
                <td>".number_format($rezago_educativo)."%</td>
                <td>".number_format($ranking7)."</td>
                <td></td>
                <td class='cabezaTabla'>Servicios de salud</td>
                <td>".number_format($servicios_de_salud)."%</td>
                <td>".number_format($ranking8)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Seguridad social</td>
                <td>".number_format($seguridad_social)."%</td>
                <td>".number_format($ranking9)."</td>
                <td></td>
                <td class='cabezaTabla'>Calidad y espacios</td>
                <td>".number_format($calidad_y_espacios)."%</td>
                <td>".number_format($ranking10)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Servicios basicos en la vivienda</td>
                <td>".number_format($servicios_basicos_en_la_vivienda)."%</td>
                <td>".number_format($ranking11)."</td>
                <td></td>
                <td class='cabezaTabla'>Acceso a la alimentación</td>
                <td>".number_format($acceso_a_la_alimentacion)."%</td>
                <td>".number_format($ranking12)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Con al menos una carencia</td>
                <td>".number_format($con_al_menos_una_carencia)."%</td>
                <td>".number_format($ranking13)."</td>
                <td></td>
                <td class='cabezaTabla'>Tres o más carencias</td>
                <td>".number_format($tres_o_mas_carencias)."%</td>
                <td>".number_format($ranking14)."</td>
                </tr>
                <tr>
                <td class='cabezaTabla'>Inferior a línea de pobreza por ingresos</td>
                <td>".number_format($inferior_a_linea_de_pobreza_por_ingresos)."%</td>
                <td>".number_format($ranking15)."</td>
                <td></td>
                <td class='cabezaTabla'>Línea pobreza extrema por ingresos</td>
                <td>".number_format($linea_pobreza_extrema_por_ingresos)."%</td>
                <td>".number_format($ranking16)."</td>
                </tr>
                ";
            };
            ?>
            </table>
            <br>

            </table>
            <br>
            <?php
            $tipodecambio = 19.61;
            ?>

            <h4 class="mt-4">REMESAS</h4>
            <table class="table table-bordered">
                <thead>
                <tr class='TRTabla'>
                    <td colspan='6'>2021</td>
                    <td colspan='2'>2022</td>
                </td>
                    <tr class='TRTabla' style='background-color:#ffc3d0; color:#6a0f49'>
                        <td></td>
                        <td>ene-mar</td>
                        <td>abr-jun</td>
                        <td>jul-sep</td>
                        <td>oct-dic</td>
                        <td>Total</td>
                        <td>ene-mar</td>
                        <td>Diferencia</td>
                    </tr>
                </thead>
                <?php
            $coneval =$con->remesas($municipio);
            while ($row=mysqli_fetch_object($coneval)){
                $ene_mar=$row->ene_mar;
                $abr_jun=$row->abr_jun;
                $jul_sep=$row->jul_sep;
                $oct_dic=$row->oct_dic;
                $total2021=$row->total2021;
                $ene_mar22=$row->ene_mar22;
                $dif=$row->dif;
                $porcentajeEstatal = ($total2021*100)/4984.106837;
                

                echo "
                <tr class='text-center'>
                <td style='background-color:#6d807f; color:#fff'>Millónes de USD</td>
                <td>$ ".number_format($ene_mar,2)."</td>
                <td>$ ".number_format($abr_jun,2)."</td>
                <td>$ ".number_format($jul_sep,2)."</td>
                <td>$ ".number_format($oct_dic,2)."</td>
                <td>$ ".number_format($total2021,2)."</td>
                <td>$ ".number_format($ene_mar22,2)."</td>
                <td>".number_format($dif,2)."%</td>
                </tr>
                <tr class='text-center'>
                <td style='background-color:#6d807f; color:#fff'>MXN</td>
                <td>$".number_format((($ene_mar*$tipodecambio)*100000),0)."</td>
                <td>$".number_format((($abr_jun*$tipodecambio)*100000),0)."</td>
                <td>$".number_format((($jul_sep*$tipodecambio)*100000),0)."</td>
                <td>$".number_format((($oct_dic*$tipodecambio)*100000),0)."</td>
                <td>$".number_format((($total2021*$tipodecambio)*100000),0)."</td>
                <td>$".number_format((($ene_mar22*$tipodecambio)*100000),0)."</td>
                <td>".number_format($dif,2)."%</td>
                </tr>
                <tr>
                <td colspan='8'><b>En 2021 ingresarón a Michoacán 4,984.10 MDD -> Este municipio aportó el ".number_format($porcentajeEstatal,2)."% del total estatal<br> Tipo de cambio ".$tipodecambio." MXN</b></td>
                </tr>
                ";
            };
            ?>
            </table>
            <br>

            <h4 class="mt-4">PRODUCCIÓN AGRÍCOLA 2021<br>
                <?
                $totalVP =$con->totalMontoAgricola($municipio);
                while ($row=mysqli_fetch_object($totalVP)){
                    $totalValorProduccion=$row->totalValorProduccion;
                    echo "Valor de la producción municipal $".number_format($totalValorProduccion);
                    echo " ---> ".number_format((($totalValorProduccion/86667691746.2)*100),2)."% del valor estatal total.";
                }
                ?>
            </h4>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr class='TRTabla'>
                        <td>Ciclo Productivo</td>
                        <td>Modalidd</td>
                        <td>Cultivo</td>
                        <td>Sembrada (ha)</td>
                        <td>Cosechada</td>
                        <td>Siniestrada</td>
                        <td>Volumen producción</td>
                        <td>Rendimiento</td>
                        <td>Precio</td>
                        <td>Valor producción</td>
                        <td>%</td>
                    </tr>
                </thead>
                <?php

            $agricola =$con->reporteAgricola($municipio);
            while ($row=mysqli_fetch_object($agricola)){
                $Valorproduccion=$row->Valorproduccion;
                $Precio=$row->Precio;
                $Rendimiento=$row->Rendimiento;
                $Volumenproduccion=$row->Volumenproduccion;
                $Siniestrada=$row->Siniestrada;
                $Cosechada=$row->Cosechada;
                $Sembrada=$row->Sembrada;
                $Nomcultivo_Sin_Um=$row->Nomcultivo_Sin_Um;
                $Nommodalidad=$row->Nommodalidad ;
                $Nomcicloproductivo=$row->Nomcicloproductivo;
                

                echo "
                <tr>
                <td>".$Nomcicloproductivo."</td>
                <td>".$Nommodalidad."</td>
                <td>".$Nomcultivo_Sin_Um."</td>
                <td>".$Sembrada."</td>
                <td>".$Cosechada."</td>
                <td>".$Siniestrada."</td>
                <td>".number_format($Volumenproduccion,2)."</td>
                <td>".$Rendimiento."</td>
                <td>$".number_format($Precio)."</td>
                <td>$".number_format($Valorproduccion)."</td>
                <td>".number_format(($Valorproduccion/$totalValorProduccion)*100,2)."%</td>
                </tr>
                ";
            };
            ?>
            </table>


            <br>

<h4 class="mt-4">PRODUCCIÓN PECUARIA 2020 <br>
    <?
    $totalV =$con->totalMontoPecuario($municipio);
    while ($row=mysqli_fetch_object($totalV)){
        $totalValor=$row->totalValor;
        echo "Valor municipal $".number_format($totalValor*1000);
        echo " ---> ".number_format((($totalValor/25022296.612)*100),2)."% del valor estatal total.";
    }
    ?>
</h4>
<table class="table table-bordered table-sm">
    <thead>
        <tr class='TRTabla'>
            <td>Especie</td>
            <td>Producto</td>
            <td>Volumen</td>
            <td>Peso</td>
            <td>Precio</td>
            <td>Valor</td>
            <td>%</td>
            <td>A Sacrificado</td>
        </tr>
    </thead>
    <?php

$pecuario =$con->reportePecuario($municipio);
while ($row=mysqli_fetch_object($pecuario)){
    $Nomespecie=$row->Nomespecie;
    $Nomproducto=$row->Nomproducto;
    $Volumen=$row->Volumen;
    $Peso=$row->Peso;
    $Precio=$row->Precio;
    $Valor=$row->Valor;
    $Asacrificado=$row->Asacrificado;    

    echo "
    <tr>
    <td>".$Nomespecie."</td>
    <td>".$Nomproducto."</td>
    <td>".$Volumen."</td>
    <td>".$Peso."</td>
    <td>".$Precio."</td>
    <td>$".number_format(($Valor*1000),2)."</td>
    <td>".number_format(($Valor*1000/$totalValor)*100,2)."%</td>
    <td>".$Asacrificado."</td>
    </tr>
    ";
};
?>
</table>

            


        </div>

        <div class="row" style="background-color: #e2e2e2; padding:20px"> SIIM::Sistema de Integral de Información Municipal <br> Secretaría Técnica del Despacho del Gobernador</div>

    </main>

</div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>

</html>