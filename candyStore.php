<?php
session_start();
include './dbconn.php';
include 'includes/phpFunctions.php';

//$dbConn = getDBConnection("candy_store");
$dbConn = getDBConnection("heroku_f1e413901d54873");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <style>
            @import url('./css/styles.css');
            #header_div {
                background-image: url("./images/headerImage.png");
                background-size: cover;
            }
        </style>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!-- Latest compiled JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet"> 
        <title> Kid in a candy store!</title>
        <script>
            function getProducts() {
                var sort_by_price = false;
                var cbox = $('#candy_price');
                if(cbox.is(':checked')) {
                    //alert("bold is checked");
                    sort_by_price = true;
                }
                $("#results").html("");
                $.ajax({
                    type: "get",
                    url: "checkResults.php",
                    dataType: "json",
                    data: { "itemName": $("#candy_name").val(),
                            "itemType": $("#candy_type").val(),
                            "itemPrice": sort_by_price
                    },
                    success: function(data,status) {
                        //alert(data.productName);
                        if(data.productName == "–") {
                            $("#results").html("<tr><td style=\"width:20%\">"+data.productName +"</td><td style=\"width:60%\">" + data.productDescription +"</td><td>" + data.productPrice + "</td></tr>");
                        }
                        var i = 0;
                        for(i;i<data.length;i++){
                            var price = "$" + parseFloat(data[i].productPrice).toFixed(2);
                            $("#results").append("<tr><td style=\"width:20%\">"+data[i].productName +"</td><td style=\"width:60%\">" + data[i].productDescription +"</td><td>" + price + "</td></tr>");
                        }
                        $("#candy_name").val("");
                      },
                      complete: function(data,status) { //optional, used for debugging purposes
                          //alert(status);
                      }
               });//AJAX 
               
            }
            
        </script>
    </head>
    <body>
        <div class="jumbotron">
            <div id="header_div" style="padding-bottom:50px">
                <h1 id="store_title"> Kid in a Candy Store!</h1><br/>
                <a href='adminLogin.php' style="padding-right:30px; float: right">
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-user" ></span> Admin
                    </button>
                </a>
            </div>
            <div>
                <form style="margin-top: 15px" class="form-inline" >
                    <div class="form-group">
                        <label for="product_name">Product:</label>
                        <input id="candy_name" type="text" class="form-control" name="product_name"/>
                    </div>
                    <div class="form-group">    
                        <select id="candy_type" class="selectpicker" data-style="btn-block btn-primary" name="itemType">
                            <option value="">-Select Type-</option>
                            <option value="1">Chocolate</option>
                            <option value="2">Hard Candy</option>
                            <option value="3">Gummy Candy</option>
                            <option value="4">Licorice</option>
                        </select>
                    </div>
                    <div class="checkbox">
                        <label> By Price: <input id="candy_price" type="checkbox" name="price" style="margin-right:10px"></label>
                    </div>
                    <!--<button type="submit" class="btn btn-primary">Search</button>-->
                    <input type="button" onclick="getProducts()" class="btn btn-primary" value="Search">
                </form>
            </div>
            <div class="row" >
                <div class="col-sm-offset-1 col-sm-10" style="height:75%; overflow-y: scroll !important">
                    <table class="table table-hover table-striped">
                        <thead ><tr>
                            <th style="text-align:center">Product Name</th>
                            <th style="text-align:center">Product Description</th>
                            <th style="text-align:center">Product Price</th>
                        </tr></thead>
                    </table>
                    <table  class="table table-hover table-striped">
                        <tbody id="results">
                            
                            
                        </tbody>
                        
                </table>
                </div>
            </div>
            
        </div>
    </body>
</html>