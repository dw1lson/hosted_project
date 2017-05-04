<?php
session_start();

if(!isset($_SESSION['username'])){
    header("Location: candyStore.php");
}

include './dbconn.php';
include 'includes/phpFunctions.php';
$dbConn = getDBConnection();

if(isset($_GET['productId'])) {
    global $dbConn;
    $itemInfo = getItemInfo($_GET['productId']);
    //print_r($userInfo);
}

function selectManufacturer($manufacturerId){
    global $itemInfo;
    if ($itemInfo['manufacturerId'] == $manufacturerId){
        return 'selected';
    }
}
function selectType($type){
    global $itemInfo;
    if($itemInfo['typeId'] == $type){
        return "selected";
    }
}

if(isset($_GET['submit'])) {  //admin has submitted the "update user" form
    global $dbConn;
    $sql = "UPDATE product
            SET productName = :pName,
                productDescription = :desc,
                typeId = :type,
                manufacturerId = :manufacturer,
                productPrice = :price,
                productQty = :quantity
            WHERE productId = :productId";
    $np = array();
    $np[':productId'] = $_GET['itemId'];
    $np[':pName']  = $_GET['itemProductName'];  
    $np[':desc']  = $_GET['itemDescription'];
    $np[':type']  = $_GET['itemType'];
    $np[':manufacturer']  = $_GET['itemManufacturer'];
    $np[':price']  = $_GET['itemPrice'];
    $np[':quantity']  = $_GET['itemQuantity'];
    $stmt = $dbConn->prepare($sql);
    $stmt->execute($np);
    echo " Record was updated!";
    header("Location: admin.php");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <style>
            @import url('./css/styles.css');
            #header_div {
                background-image: url("./images/headerImage.png");
                background-size: cover;
                margin-bottom:10px !important;
            }
            h1,#admin_welcome {
                font-family: 'Julius Sans One', sans-serif;
                font-size: 3rem;
                text-align: center;
                color: black;
            }
        </style>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One" rel="stylesheet">
        <title>Update Item </title>
    </head>
    <body>
        <div class="jumbotron">
            <div style="padding-bottom: 15px">
                <h1 id="admin_title">Update Item Info</h1>
                <a href='admin.php' style="padding-right:30px; float: right">
                     <button type="button" class="btn btn-info btn-med">
                         <span class="glyphicon glyphicon-user" ></span>Main Admin
                     </button>
                 </a>
             </div>
            <hr>
            <form class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemId">Product Id:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="itemId" value="<?=$itemInfo['productId']?>" disabled/>
                        <input type="hidden" class="form-control" name="itemId" value="<?=$itemInfo['productId']?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemProductName">Product Name:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="itemProductName" value="<?=$itemInfo['productName']?>"/>
                    </div>
                </div>
                <!--<div class="form-group">-->
                <!--    <label class="control-label col-sm-4" for="itemDescription">Product Desc.:</label>-->
                <!--    <div class="col-sm-4">-->
                <!--        <input type="text" class="form-control" name="itemDescription" value="<=$itemInfo['productDescription']?>"/>-->
                <!--    </div>-->
                <!--</div>-->
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemDescription">Product Desc:</label>
                    <div class="col-sm-4">
                        <textarea rows="4" maxlength="300" class="form-control" name="itemDescription" placeholder="<?=$itemInfo['productDescription']?>"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemPrice">Product Price:</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="itemPrice" step="0.01" value="<?=sprintf("%.2f", $itemInfo['productPrice'])?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemQuantity">Quantity:</label>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" step="1" name="itemQuantity" value="<?=$itemInfo['productQty']?>"/>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemType">Product Type:</label>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-block btn-primary" name="itemType">
                            <option value="1" <?=selectType(1)?> >Chocolate</option>
                            <option value="2" <?=selectType(2)?> >Hard Candy</option>
                            <option value="4" <?=selectType(4)?> >Licorice</option>
                            <option value="3" <?=($itemInfo['typeId']== 3)? 'selected':''?> >Gummy Candy</option>
                        </select>
                    </div>
                </div>
                <br/>
                <div class="form-group">
                    <label class="control-label col-sm-4" for="itemManufacturer">Manufacturer:</label>
                    <div class="col-sm-4">
                        <select class="selectpicker" data-style="btn-block btn-primary" name="itemManufacturer">
                            <option value="">Select One</option>
                            <?php
                                $departments = getSelectedManufacturer();
                            ?>
                        </select>
                        </div>
                </div>
                <br/>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-4">
                        <input type="submit" style="margin-bottom:15px" class="btn btn-block btn-primary" name="submit" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>