<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  

    
$libreta = $_GET['libreta'];


    $res=$cnx->borraLibreta($libreta);
					if($res){
						header ('location: index.php');
					}else{
						echo "error";
					}

?>