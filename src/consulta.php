<?php

include('../ajax/config.php');
//Configuracion de la conexion a base de datos
$seccion = $_POST['seccionBusqueda'];
$serie  = $_POST['serieBusqueda'];
$subserie  = $_POST['subserieBusqueda'];


echo "<table class='table table-striped table-bordered'>";
echo "<th style='width: 40%'>Documento</th>
<th style='width: 45%'>descripcion</th>
<th style='width: 15%'>Fecha</th>";
$sql1 = "SELECT * FROM documentos WHERE seccion = '$seccion' ORDER BY id ASC";
$result = $conn->query($sql1);
if ($result->num_rows > 0) {
                                      // output data of each row
while($row = $result->fetch_assoc()) {
echo "<tr><td> <a href='uploads/".$row['seccion']."/".$row['serie']."/".$row['subserie']."/".$row['archivo']."' target='_blank'><button class='btn btn-outline-success btn-sm'><i class='bi bi-folder2-open'></i> abrir</button></a> ".$row['nombre']."</td>
<td>".$row['descripcion']."</td>
<td>".$row['bitacora']."</td>
 </tr>";
}
} else {
echo "sin resultados";
}
echo "</table>";
?>
