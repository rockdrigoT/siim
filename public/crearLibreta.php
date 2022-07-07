<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  

    
$uppLibreta = $_POST['uppLibreta'];
$descripcionLibreta = $_POST['descripcionLibreta'];
$nombreLibreta = $_POST['nombreLibreta'];
$fechaRegistro = date('Y-m-d');
$autor = $_SESSION['name'];


    $res=$cnx->guardaLibretaNueva($uppLibreta, $nombreLibreta, $descripcionLibreta, $autor, $fechaRegistro);
					if($res){
						header ('location: index.php');
					}else{
						echo "error";
					}

?>