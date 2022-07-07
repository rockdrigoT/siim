<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  


    
    $idAcuerdo = $_GET['idAcuerdo'];
	$uppColaboradora = $_GET['uppColaboradora'];
	$libreta=$_GET['libreta'];


    $res=$cnx->eliminarColaborador($idAcuerdo, $uppColaboradora);
					if($res){
						if(isset($libreta)){
							header ('location: libreta.php?libreta='.$libreta.'');
						}else{
							header ('location: index.php');
						}
					}else{
						echo "error";
					}
?>