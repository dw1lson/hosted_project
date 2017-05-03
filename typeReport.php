<?php
session_start();

include '../common/dbconn.php';

$conn = getDBConnection("candy_store");
function getProducts($id){
    global $conn;
   
    $sql = "SELECT productName, productQty, manufacturerName FROM product p INNER JOIN manufacturer m ON p.manufacturerId = m.manufacturerId WHERE typeId = :typeId ORDER BY manufacturerName, productName";
    
    $namedParameters[':typeId'] = $id;
    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $records;
    
}

function getTypeName($id){
    global $conn;
    $sql = "SELECT typeDescription FROM type WHERE typeId = :typeId";
    
    $namedParameters[':typeId'] = $id;
    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    return $record;
}

function getTotals($id){
    global $conn;

    $sql = "SELECT COUNT(productName) AS totalProducts FROM product WHERE typeId = :typeId";
    
    $namedParameters[':typeId'] = $id;
    
    
    $statement = $conn->prepare($sql);
    $statement->execute($namedParameters);
    $record = $statement->fetch(PDO::FETCH_ASSOC);
    return $record;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One" rel="stylesheet">
        <style>
            @import url('./css/styles.css');
            .table {
                height:75%;
                overflow-y: scroll;
                
            }
            
            .jumbotron,admin {
                padding-top:10px !important;
                position: absolute;
                left:50%;
                top:50%;
                transform: translate(-50%, -45%);
                width: 90%;
                height:80%;
                text-align:center;
                background-color: rgba(255, 255, 255) !important;
                box-shadow: 10px 10px 10px #5E6C70;
                vertical-align: middle;
            }
            #header_div {
                background-image: url("./images/headerImage.png");
                background-size: cover;
                margin-bottom:10px !important;
            }
            h3,#admin_welcome {
                font-family: 'Julius Sans One', sans-serif !important;
                font-size: 2rem;
                text-align: center;
                color: black;
            }
        </style>
        <title> Type Report </title>
    </head>
    <body>
        <div class="jumbotron" id="admin" style="background-color: rgba(255, 255, 255) !important">
            <div id="header_div" style="padding-bottom:50px">
                <h1 id="admin_title"> Type Report</h1>
    
                <a href='admin.php' style="padding-right:30px; float: right">
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-user" ></span> Admin
                    </button>
                </a>
                <a href='logout.php' style="padding-left:30px; float: left">
                    <button type="button" class="btn btn-danger btn-med">
                        <span class="glyphicon glyphicon-remove" ></span> Logout
                    </button>
                </a>
            </div>
            <hr>
            <?php
                for($j = 1; $j < 5; $j++){
                    echo "<div class=\"row\" >";
                    echo "<div class=\"col-sm-offset-1 col-sm-10\" >";
                    $type = getTypeName($j);
                    echo "<h2>" .$type['typeDescription']. " candy</h2><hr/>";
                    $products = getProducts($j);
                    echo "<table class=\"table table-striped table-hover\" >";
                    echo "<thead><tr>";
                    echo "<th style=\"text-align:center\"><h3>Product Name</h3></th>";
                    echo "<th style=\"text-align:center\"><h3>Manufacturer</h3></th>";
                    echo "<th style=\"text-align:center\"><h3>Quantity</h3></th>";
                    echo "</tr></thead>";
                    foreach($products as $product){
                        echo "<tr><td><h4>" .$product['productName']. "</h4></td>";
                        echo "<td><h4>" .$product['manufacturerName']. "</h4></td>";
                        echo sprintf("<td> %u </td></tr>", $product['productQty']);
                    }
                    $total = getTotals($j);
                    echo sprintf("<tr><td></td><td><h4>Total Products:</h4></td><td> %u </td></tr>",$total['totalProducts']);
                    echo "</table>";
                    echo "</div>";
                    echo "</div><br/>";
                }
            ?>
            
        </div>
        
        

    </body>
</html>