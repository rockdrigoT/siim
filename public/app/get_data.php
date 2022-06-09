<?php

// require_once '../../../src/utils.php';
//     include  '../../../src/verificaUser.php';   
//     $miUpp = $_SESSION['miupp'];


try {
    $conn = new PDO('mysql:host=localhost;dbname=siim','da_admin','d7LUdPKBfe');
} catch (PDOException $exception) {
    die($exception->getMessage());
}

$sql = "SELECT * FROM acciones";
$st = $conn
    ->query($sql);

if ($st) {
    $rs = $st->fetchAll(PDO::FETCH_FUNC, fn($id, $upp, $programa, $municipio, $localidad, $accion, $descripcion, $monto) => [$id, $upp, $programa, $municipio, $localidad, $accion,  $descripcion, $monto] );

    echo json_encode([
        'data' => $rs,
    ]);
} else {
    var_dump($conn->errorInfo());
    die;
}