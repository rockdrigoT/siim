<?php
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login.php");
    exit;
}

$user = [];	
$C = connect();
if($C) {
    $res = sqlSelect($C, 'SELECT * FROM users WHERE id=?', 'i', $_SESSION['userID']);
    if($res && $res->num_rows === 1) {
        $user = $res->fetch_assoc();
    }
    else {
        exit;
    }
}
else {
    exit;
}
