<?php
header('Access-Control-Allow-Origin: *');
session_start();
include './dbconn.php';
$dbConn = getDBConnection("heroku_f1e413901d54873");

$productId = $_GET['itemId'];

$sql = "SELECT productName FROM product WHERE productId = $itemId";
$stmt = $dbConn -> prepare ($sql);
$stmt -> execute ();
$record = $stmt->fetch(PDO::FETCH_ASSOC);
//return $record;
echo $json = '{"itemName": "' .$record.'}';

?>