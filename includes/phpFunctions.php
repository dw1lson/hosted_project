<?php


function getSelectedManufacturer(){
    global $dbConn;
   // $sql = "SELECT distinct(deptName) from department";
    $sql = "SELECT * FROM manufacturer ORDER BY manufacturerName";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute ();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($records as $record){
    echo '<option ' .selectManufacturer($record['manufacturerId']). ' value="' . $record['manufacturerId'] .'">'. $record['manufacturerName'] . '</option>';
    //echo "<option ".selectDepartment($department['departmentId'])." value ='" . $department['departmentId']. "'>" . $department['deptName']    ." </option>";
    }
}

function getManufacturers(){
    global $dbConn;
   // $sql = "SELECT distinct(deptName) from department";
    $sql = "SELECT * FROM manufacturer ORDER BY manufacturerName";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute ();
    $records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach($records as $record){
    echo '<option value="' . $record['manufacturerId'] .'">'. $record['manufacturerName'] . '</option>';
    //echo "<option ".selectDepartment($department['departmentId'])." value ='" . $department['departmentId']. "'>" . $department['deptName']    ." </option>";
    }
}

function getItemInfo($itemId){
    global $dbConn;
    $sql = "SELECT * FROM product WHERE productId = $itemId";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute ();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    return $record;
}

function getItemName($itemId){
    global $dbConn;
    $sql = "SELECT productName FROM product WHERE productId = $itemId";
    $stmt = $dbConn -> prepare ($sql);
    $stmt -> execute ();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
    //return $record;
    echo $json = '{"itemId": "' .$record.'}';
}

?>