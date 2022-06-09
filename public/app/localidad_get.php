<?php

    $conn = new mysqli('localhost', 'root', 'root', 'infraestructura_michoacan') or die(mysqli_error());
	
	$municipio=$_REQUEST['municipio'];
	$sql = $conn->prepare("SELECT distinct nombre_tenencia FROM catalogo_comunidades WHERE nombre_municipio = '$municipio' ORDER BY nombre_tenencia ASC");
    
	// $sql_municipios = $conn->prepare("SELECT distinct nombre_tenencia FROM catalogo_comunidades WHERE nombre_municipio = '$municipio'") or die(mysqli_error());
		// echo '<option value = "">Selecciona una comunidad</option>';
		// if($sql->execute()){
	if($sql->execute()){
		$a_result = $sql->get_result();
	}
	while($row = $a_result->fetch_array()){
?>
<option value="<?php echo $row['nombre_tenencia']?>"><?php echo $row['nombre_tenencia']?></option>
<?php
}
$conn->close();	
?>