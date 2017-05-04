<?php
session_start();
include './dbconn.php';

$conn = getDBConnection();

$username = $_POST['username'];
$password = sha1($_POST['password']);   //hash("sha1",$_POST['password']);

//USE NAMEDPARAMETERS TO PREVENT SQL INJECTION
//$sql = "SELECT * FROM admin WHERE username = '$username' AND password = '$password'";
$sql = "SELECT * FROM admin WHERE username = :username AND password = :password";

$namedParameters[':username'] = $username;
$namedParameters[':password'] = $password;


$statement = $conn->prepare($sql);
$statement->execute($namedParameters);
$record = $statement->fetch(PDO::FETCH_ASSOC);

//print_r($record);

 if (empty($record)) { //wrong credentials
   
     header("Location: adminLogin.php?login=wrong+password");
 
     
 } else {
     
     $_SESSION["adminName"] = $record['firstName'] . " " . $record['lastName'];
     $_SESSION["username"]  = $record['username'];
     header("Location: admin.php"); //redirect to the main admin program
     
 }

?>
