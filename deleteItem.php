<?php
session_start();

if (!isset($_SESSION["username"])) {  //Check whether the admin has logged in
    header("Location: candyStore.php"); 
}

include './dbconn.php';

$dbConn = getDBConnection("heroku_f1e413901d54873");

$sql = "DELETE FROM product
        WHERE productId = " .$_GET['itemId'];
$stmt = $dbConn -> prepare($sql);
$stmt->execute();
header("Location: admin.php");

?>