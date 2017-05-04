<?php
session_start();

if (!isset($_SESSION["username"])) {  //Check whether the admin has logged in
    session_destroy();
    header("Location: candyStore.php"); 
}

include './dbconn.php';

$dbConn = getDBConnection("cheroku_f1e413901d54873");

function getAllItems() {
    global $dbConn;
    $sql = "SELECT * FROM product ORDER BY productName";
    $statement = $dbConn->prepare($sql);
    $statement->execute();
    $records = $statement->fetchAll(PDO::FETCH_ASSOC);
    
    return $records;
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
        <title>Admin Page </title>
        <script>
            function confirmDelete(productId) {
                var confirmDelete = confirm("Do you really want to delete " + productId + " ?");
                if (!confirmDelete) {
                    return false;
                }
            }
            
            function getProductName(productId) {
                $.ajax({
                type: "get",
                url: "checkProductName.php",
                dataType: "json",
                data: { "itemId": productId },
                success: function(data,status) {
                    alert(data.itemName);
                    //$("#city").html(data.city);
                    // confirm("Do you really want to delete " + data.itemId + " ?");
                    // if (!confirmDelete) {
                    //     return false;
                    // }
                },
                complete: function(data,status) { //optional, used for debugging purposes
                      //alert(status);
                    }
                });//AJAX
            }
        </script>
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
    </head>
    
    <body>
        <div class="jumbotron" id="admin" style="background-color: rgba(255, 255, 255) !important">
            <div id="header_div" style="padding-bottom:50px">
                <h1 id="admin_title"> Admin Page</h1>
                <h3 id="admin_welcome"> Welcome <?=$_SESSION['adminName']?> </h3>
    
                <a href='addNewItem.php' style="padding-right:30px; float: right">
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-plus" ></span> New Item
                    </button>
                </a>
                <a href='logout.php' style="padding-left:30px; float: left">
                    <button type="button" class="btn btn-danger btn-med">
                        <span class="glyphicon glyphicon-remove" ></span> Logout
                    </button>
                </a>
            </div>
            <div class="holder">
                <a href='costReport.php' >
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-usd" ></span> Cost Report
                    </button>
                </a> 
                <a href='itemReport.php' >
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-barcode" ></span> Item Report
                    </button>
                </a>     
                <a href='typeReport.php' >
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-tasks" ></span> Type Report
                    </button>
                </a>    
            </div>
        
            <div class="row" >
                <div class="col-sm-offset-1 col-sm-10" style="height:75%; overflow-y: scroll !important">
                    <?php
                    
                        $items = getAllItems();
                        echo "<table class=\"table table-striped table-hover\" >";
                        echo "<thead><tr>";
                        echo "<th style=\"text-align:center\">Product Name</th>";
                        echo "<th style=\"text-align:center\">Price</th>";
                        echo "<th style=\"text-align:center\">Quantity</th>";
                        echo "<th></th>";
                        echo "</tr></thead>";
    
                        foreach ($items as $item) {
                            echo "<tr>";
                            echo "<td><a href='' onclick='window.open(\"itemInfo.php?item_name=" . $item['productName'] . " \", \"Item Info\")'>" . $item['productName'] . " </a></td> "; 
                            echo sprintf("<td> $%.2f </td>",$item['productPrice']);
                            //echo "<td> $" . $item['productPrice'] . "</td>";
                            echo "<td>" . $item['productQty'] . "</td>";
                            //echo "<a href='userUpdate.php?userId=".$user['userId']."'>[Update]</a> ";
                            echo "<td><a href='itemUpdate.php?productId=".$item['productId']."'>
                                 <button type=\"button\" class=\"btn btn-default btn-sm\">
                                 <span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span> Update
                                 </button></a>";
                            echo "<a onclick=getProductName(" . $item['productId'] . ")  href='deleteItem.php?itemId=".$item['productId']."'>
                                 <button type=\"button\" class=\"btn btn-danger btn-sm\">
                                 <span class=\"glyphicon glyphicon-remove\" aria-hidden=\"true\"></span> Delete
                                 </button></a>"; 
                            echo "</td></tr>";
                        }
                        echo "</table>";
                    ?>
                </div>
            </div>
        </div>
    </body>
</html>