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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">



    <link href="assets/css/com_ind.css" rel="stylesheet" />
    <link href="assets/css/loader.css" rel="stylesheet" />
    <link href="assets/css/dashboard.css" rel="stylesheet" />
    <title>CCI_V1.1</title>

    <script language="javascript">
    $(document).ready(function() {
        $("#municipio").on('change', function() {
            $("#municipio option:selected").each(function() {
                elegido = $(this).val();
                $.post("localidad.php", {
                    elegido: elegido
                }, function(data) {
                    $("#localidad").html(data);
                });
            });
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


    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div
            class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Agregar obra</h1>
        </div>
        <div class="col-12 mb-4">
            <form method="post" action="guardaNuevaAccion.php" class="col-lg-6 col-md-8 col-sm-12 mx-auto">
                <div class="mb-3">
                    <label>Selecciona municipio</label>
                    <select class="form-select" name="municipio" id="municipio">
                        <?php
                        $conn = new mysqli('localhost', 'root', 'root', 'infraestructura_michoacan') or die(mysqli_error());	
									$sql = $conn->prepare("SELECT distinct nombre_municipio FROM catalogo_comunidades ORDER BY nombre_municipio ASC");
									if($sql->execute()){
										$g_result = $sql->get_result();
									}
									while($row = $g_result->fetch_array()){
								?>
                        <option value="<?php echo $row['nombre_municipio']?>"><?php echo $row['nombre_municipio']?></option>
                        <?php
								}
							$conn->close();	
						?>

                    </select>
                </div>
                <div class="mb-3">
                    <label>Selecciona localidad</label>
                    <select class="form-select" name="localidad" id="localidad">
                    </select>
                </div>

                <div class="mb-3">
                    <label>Selecciona la UPP</label>
                    <select class="form-select" name="upp" id="upp">
                        <option value="SCOP">SCOP</option>
                        <option value="CEAC">CEAC</option>
                        <option value="IVEM">IVEM</option>
                        <option value="SFA">SFA</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Tipo de acción</label>
                    <select class="form-select" name="accion" id="accion">
                    <option value="obra">obra</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Descripción</label>
                    <textarea type="text" class="form-control" name="descripcion" id="descripcion" ></textarea>
                </div>

                <div class="mb-3">
                    <label>Monto</label>
                    <input type="number" class="form-control" name="monto" id="monto" />
                </div>

                <input type="hidden" name="avance" id="avance" value="0"/>

                <input type="submit" class="btn btn-primary" value="guardar acción"/>
            </form>
        </div>
    </main>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
    <script type = "text/javascript">
	$(document).ready(function(){
		$('#municipio').on('change', function(){
				if($('#municipio').val() == ""){
					$('#localidad').empty();
					$('<option value = "">Selecciona una localidad</option>').appendTo('#localidad');
					$('#localidad').attr('disabled', 'disabled');
				}else{
					$('#localidad').removeAttr('disabled', 'disabled');
					$('#localidad').load('localidad_get.php?municipio=' + $('#municipio').val());
				}
		});
	});
</script>

</body>

</html>