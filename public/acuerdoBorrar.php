<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  


    
    $idAcuerdo = $_GET['idAcuerdo'];
	$fechaTermino = date('Y-m-d');
	$libreta = $_GET['libreta'];

    $res=$cnx->borrarAcuerdo($idAcuerdo);
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