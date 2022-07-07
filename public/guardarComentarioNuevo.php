<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
$cnx = new consultasAcuerdos();  

    
    $idAcuerdo = $_POST['idAcuerdo'];
	$comentario = $_POST['comentario'];
	$upp = $_POST['uppComento'];
	$bitacora = date('Y-m-d');


    $res=$cnx->agregarComentario($idAcuerdo, $comentario, $upp, $bitacora);
					if($res){
						header ('location: index.php');
					}else{
						echo "error";
					}
?>