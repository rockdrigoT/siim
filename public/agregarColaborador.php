<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");

    
    $idAcuerdo = $_POST['idAcuerdo'];
	$uppColaboradora = $_POST['uppColaboradora'];
	$libreta = $_POST['libreta'];

    $cnx = new consultasAcuerdos();  
    $res=$cnx->agregarColaborador($idAcuerdo, $uppColaboradora);
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