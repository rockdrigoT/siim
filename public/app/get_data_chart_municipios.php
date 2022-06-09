<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

try {
    $conn = new PDO('mysql:host=localhost;dbname=infraestructura_michoacan','root','root');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

$sql = "SELECT DISTINCT municipio, COUNT(*) from acciones GROUP BY municipio";
$sql2 = "SELECT DISTINCT municipio, COUNT(*) from acciones GROUP BY municipio";
$sql3 = "SELECT DISTINCT municipio, SUM(monto) AS total from acciones GROUP BY municipio";
$sql4 = "SELECT DISTINCT municipio, SUM(monto) AS total from acciones GROUP BY municipio";
$st = $conn
    ->query($sql);

    $st2 = $conn
    ->query($sql2);

    $st3 = $conn
    ->query($sql3);

    $st4 = $conn
    ->query($sql4);

if ($st) {
    $rs_etiquetas = $st->fetchAll(PDO::FETCH_COLUMN,0);
    $rs_datos = $st2->fetchAll(PDO::FETCH_COLUMN,1);
    $rs_etiquetas_monto = $st3->fetchAll(PDO::FETCH_COLUMN,0);
    $rs_datos_monto = $st4->fetchAll(PDO::FETCH_COLUMN,1);

    echo json_encode([
        'etiquetas' => $rs_etiquetas,
        'datos' => $rs_datos,
        'etiquetas_monto' => $rs_etiquetas_monto,
        'datos_monto' => $rs_datos_monto,
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}


// $etiquetas = ["Enero", "Febrero", "Marzo", "Abril"];
// $datosVentas = [5000, 1500, 8000, 5102];
// // Ahora las imprimimos como JSON para pasarlas a AJAX, pero las agrupamos
// $respuesta = [
//     "etiquetas" => $etiquetas,
//     "datos" => $datosVentas,
// ];
// echo json_encode($respuesta);
