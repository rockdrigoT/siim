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

	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

    <script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
	<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <link href="assets/css/com_ind.css" rel="stylesheet" />
    <link href="assets/css/loader.css" rel="stylesheet" />
    <link href="assets/css/dashboard.css" rel="stylesheet" />
    <title>CCI_V1.1</title>
    <script type="application/javascript" class="init">
$(document).ready(function() {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        columnDefs:[
            {
                targets: 7,
                render: $.fn.dataTable.render.number(',','.',2,'$')
            }
        ],
        "ajax": 'get_data.php',
        "pageLength": 10,
        "language": {
            buttons:{
                copy: "Copiar",
                print: "Imprimir"
            },
            "lengthMenu": "Mostrando _MENU_ registros por página",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando página _PAGE_ de _PAGES_",
            "infoEmpty": "Sin registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros)",
            "search": "Buscar:",
            "loadingRecords": "Cargando...",
            "processing": "Procesando...",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Siguiente",
                "previous": "Anterior"
            },
        },
        
    });
});
</script>
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


    <main class="col-md-11 ms-sm-auto col-lg-11 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Listado de acciones en infraestructura</h1>
        </div>

        <div class="col-12 mb-4">
            <table id="example" class="display" style="width: 100%">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>upp</th>
                        <th>programa</th>
                        <th>municipio</th>
                        <th>localidad</th>
                        <th>accion</th>
                        <th>descripcion</th>
                        <th>monto</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                    <th>id</th>
                        <th>upp</th>
                        <th>programa</th>
                        <th>municipio</th>
                        <th>localidad</th>
                        <th>accion</th>
                        <th>descripcion</th>
                        <th>monto</th>
                    </tr>
                </tfoot>
            </table>

        </div>

    </main>



    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

</body>

</html>
