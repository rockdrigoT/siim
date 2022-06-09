<?php
// Valores con PHP. Estos podrían venir de una base de datos o de cualquier lugar del servidor

try {
    $conn = new PDO('mysql:host=localhost;dbname=infraestructura_michoacan','root','root');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

$sql = "SELECT DISTINCT municipio, COUNT(*) from acciones GROUP BY municipio";
$sql2 = "SELECT DISTINCT municipio, COUNT(*) from acciones GROUP BY municipio";
$st = $conn
    ->query($sql);

    $st2 = $conn
    ->query($sql2);

if ($st) {
    $rs_etiquetas = $st->fetchAll(PDO::FETCH_COLUMN,0);
    $rs_datos = $st2->fetchAll(PDO::FETCH_COLUMN,1);

    echo json_encode([
        'etiquetas' => $rs_etiquetas,
        'datos' => $rs_datos,
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}
