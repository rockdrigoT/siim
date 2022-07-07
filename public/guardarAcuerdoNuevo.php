<?php 
require_once '../src/utils.php';
include  '../src/verificaUser.php'; 
include ("../classes/consultas.php");
    
    $uppResponsable = $_POST['uppResponsable'];
    $acuerdo = $_POST['acuerdo'];
    $libreta = $_POST['libreta'];
    $autor = $_POST['autor'];
	$fechaRegistro = date('Y-m-d');

    include ("./classes/consulta.php");
    $cnx = new consultasAcuerdos();  
    $res=$cnx->guardaNuevoAcuerdo($uppResponsable, $acuerdo, $fechaRegistro, $libreta, $autor);
					if($res){
						if(!$libreta == 0){
							header ('location: libreta.php?libreta='.$libreta.'');
						}else{
							header ('location: index.php');
						}
						
					}else{
						echo "error al guardar acuerdo";
					}
?>