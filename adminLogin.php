<?php
function alertPopup() {
    echo "<div class=\"container\"><div class=\"alert alert-danger alert-dismissable\"><a href=\"adminLogin.php\" class=\"close\" data-dismiss=\"alert\" aria-label=\"close\">close</a><strong>Alert!</strong> Incorrect username or password.</div></div>";
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
        </style>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        
        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Bangers" rel="stylesheet"> 
        <link href="https://fonts.googleapis.com/css?family=Julius+Sans+One" rel="stylesheet"> 
        <title> Admin Section: Login Screen</title>
    </head>
    <body>
        <div class="jumbotron">
            <div id="header_div" style="padding-bottom:50px">
                <h1 id="store_title"> Kid in a Candy Store!</h1>
                <a href='candyStore.php' style="padding-right:30px; float: right">
                    <button type="button" class="btn btn-info btn-med">
                        <span class="glyphicon glyphicon-home" ></span> Home
                    </button>
                </a>
            </div>
            <h2 id="admin_title"> Admin Section</h2>
            <form method="post" class="form-horizontal" action="loginProcess.php">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="username">Username:</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="username" placeholder="Username">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password:</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="password" placeholder="Enter password">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-8">
                        <input type="submit" name="submitForm" class="btn btn-block btn-primary" value="Login">
                    </div>
                </div>
            </form>
            <?php 
                if($_GET['login'] == "wrong password"){
                    alertPopup();
                }
            ?>
        </div>
    </body>
</html>
