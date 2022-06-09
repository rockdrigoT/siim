<?php

 include ("classes/consultas.php");
 $con = new consulta();
 $municipio = $_GET['municipio'];
     $nomMun =$con->encuentraMunicipio($municipio);
    while ($row1=mysqli_fetch_object($nomMun)){
     $nombreMunicipio = $row1->municipio;
	 $mpio = $nombreMunicipio;
 }

require('fpdf184/mysql_table.php');

class PDF extends PDF_MySQL_Table
{
}

// Connect to database
$link = mysqli_connect('localhost','da_admin','d7LUdPKBfe','siim');


$pdf = new PDF();
$pdf->AddPage();
$pdf->SetTextColor(106,15,73);
$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,10,utf8_decode('Ficha información municipal ').$mpio.'');
$pdf->Ln();

// (TABLA INDICADORES BIENESTAR)
$pdf->AddCol('beneficiariosHogar',40,'Beneficiarios por hogar','C');
$pdf->AddCol('rk',40,'Ranking municipal','C');
$pdf->AddCol('coberturaAdultos',40,'Cobertura adultos mayores','C');
$pdf->AddCol('coberturaDiscapacidad',40,'Cobertura discapacidad','C');
$prop2 = array('HeaderColor'=>array(255,195,208),
			'color1'=>array(239,239,239),
			'color2'=>array(255,255,255),
			'padding'=>2);
$pdf->Table($link,'select format(beneficiarios_por_hogar,1) AS beneficiariosHogar, rk, format(cobertura_adultos_mayores,2) as coberturaAdultos, format(cobertura_discapacidad,2) as coberturaDiscapacidad from indicadores_bienestar WHERE clave_mun = '.$municipio.' ',$prop2);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,10,'Desglose de beneficiarios');
$pdf->Ln(8);
$pdf->SetTextColor(2,1,2);

// Second table: specify 3 colums (TABLA BENESTAR MONTOS)
$pdf->AddCol('',120,'Total de beneficiarios','C');
$pdf->AddCol('total',30,'Beneficiarios','C');
$pdf->AddCol('montoTotal',30,'Monto','C');
$prop = array('HeaderColor'=>array(255,195,208),
			'color1'=>array(249,249,249),
			'color2'=>array(255,255,210),
			'padding'=>2);
$pdf->Table($link,'select format(ben_total,0) as total, format(monto_total,0) as montoTotal from bienestar_beneficiarios WHERE clave_mun = '.$municipio.' order by municipio',$prop);

// Second table: specify 3 colums (TABLA FAEISPUM MONTOS)
$pdf->AddCol('programa',120,'programa','C');
$pdf->AddCol('total',30,'Beneficiarios','C');
$pdf->AddCol('montoTotal',30,'Monto','C');
$pdf->TableNoHead($link,'select format(p0006_ben,0) as total, format(monto_total,0) as montoTotal from bienestar_beneficiarios WHERE clave_mun = '.$municipio.' (SELECT programa from bienestar_catalogo WHERE id_programa = "p0006")',$prop);





$pdf->SetFont('Arial','B',11);
$pdf->Cell(40,10,'FAEISPUM');
$pdf->Ln(8);
$pdf->SetTextColor(2,1,2);

// Second table: specify 3 colums (TABLA FAEISPUM MONTOS)
$pdf->AddCol('total',30,'Autorizado','C');
$pdf->AddCol('asignado',30,'Asignado','C');
$pdf->AddCol('saldo',30,'Saldo','C');
$pdf->AddCol('ministrado',30,'Ministrado','C');
$pdf->AddCol('proyectos_revision',30,utf8_decode('Proyectos revisión'),'C');
$pdf->AddCol('monto_revision',30,utf8_decode('Monto revisión'),'C');
$prop = array('HeaderColor'=>array(255,195,208),
			'color1'=>array(249,249,249),
			'color2'=>array(255,255,210),
			'padding'=>2);
$pdf->Table($link,'select format(total_autorizado,0) as total, format(asignado,0) as asignado, format(saldo,0) as saldo, ministrado, proyectos_revision, monto_revision from faeispum WHERE claveMunicipio = '.$municipio.' order by municipio',$prop);


$pdf->SetTextColor(106,15,73);
$pdf->SetFont('Arial','B',11);
$pdf->Ln(2);
$pdf->Cell(50,10,'Proyectos autorizados FAEISPUM 2022');
$pdf->Ln(8);
$pdf->SetTextColor(2,1,2);

// (TABLA FAEISPUM PROYECTOS)
$pdf->AddCol('ID_proyecto',20,'ID Proyecto','C');
$pdf->AddCol('proyecto',140,'Proyecto','L');
$pdf->AddCol('monto',20,'Monto','C');
$pdf->AddCol('estatus',20,'Estatus','C');
$prop2 = array('HeaderColor'=>array(255,195,208),
			'color1'=>array(239,239,239),
			'color2'=>array(255,255,255),
			'padding'=>2);
$pdf->Table($link,'select ID_proyecto, proyecto, format(monto,0) as monto, estatus from proyectos_faeispum_2022 WHERE clave_Municipio = '.$municipio.' order by proyecto',$prop2);

$pdf->Output();


?>