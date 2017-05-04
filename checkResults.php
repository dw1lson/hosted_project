<?php
header('Access-Control-Allow-Origin: *');
session_start();
include './dbconn.php';

$dbConn = getDBConnection();

// $np = array();
// if($_GET['itemName'] != ""){
//     $np[":productName"] = $_GET['itemName'];
// }
// $np["productType"] = $_GET['itemType'];
//echo count($np);
$productType = $_GET['itemType'];
$productName = $_GET['itemName'];

if($_GET['itemName'] != "" && $_GET['itemType'] == ""){
    $sql = " SELECT productName, productDescription, productPrice FROM product WHERE (productName LIKE '%$productName%') ORDER BY productPrice";
} elseif($_GET['itemPrice'] == true && $_GET['itemName'] != "" && $_GET['itemType'] != ""){
    $sql = " SELECT productName, productDescription, productPrice FROM product WHERE (productName LIKE '%$productName%' AND typeId = $productType) ORDER BY productPrice";
} elseif($_GET['itemPrice'] == false && $_GET['itemName'] != "" && $_GET['itemType'] != ""){
    $sql = " SELECT productName, productDescription, productPrice FROM product WHERE (productName LIKE '%$productName%' AND typeId = $productType)";
} elseif($_GET['itemPrice'] == false && $_GET['itemName'] == "" && $_GET['itemType'] != ""){
    $sql = " SELECT productName, productDescription, productPrice FROM product WHERE typeId = $productType";
} elseif($_GET['itemPrice'] == true && $_GET['itemName'] == "" && $_GET['itemType'] != "") {
    $sql = " SELECT productName, productDescription, productPrice FROM product WHERE typeId = $productType ORDER BY productPrice";
} else {
    $sql = " SELECT productName, productDescription, productPrice FROM product";
}

//$sql = "SELECT * FROM product WHERE productId < 9";
$stmt = $dbConn -> prepare($sql);
$stmt -> execute();

$json_array = array();
$records = $stmt->fetchAll(PDO::FETCH_ASSOC);

if(!$records) {
    echo $no_items = '{ "productName": "–", "productDescription": "There are no items matching your search criteria!", "productPrice": "N/A" }';
    // $noItems = array("productName"=>"–", "productDescription"=>"There are no items matching your search criteria!", "productPrice"=>"N/A");
    // echo json_encode($noItems);
} else {
    echo json_encode($records);
}
?>