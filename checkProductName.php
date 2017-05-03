<?php
header('Access-Control-Allow-Origin: *');
session_start();
include '../common/dbconn.php';
$dbConn = getDBConnection("candy_store");

$productId = $_GET['itemId'];

$sql = "SELECT productName FROM product WHERE productId = $itemId";
$stmt = $dbConn -> prepare ($sql);
$stmt -> execute ();
$record = $stmt->fetch(PDO::FETCH_ASSOC);
//return $record;
echo $json = '{"itemName": "' .$record.'}';

?>