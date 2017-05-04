<?php

function getDBConnection($dbname) {
    $host = "us-cdbr-iron-east-03.cleardb.net";
    $username = "b8a6552837f05e";
    $password = "e5c84054";
    $dbname = "heroku_f1e413901d54873";
    
    try {
        //Creating database connection
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Setting Errorhandling to Exception
        $dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    }
    catch (PDOException $e) {
        
        echo "There was some problem connecting to the database! Error: $e";
        exit();
        
    }
    
    return $dbConn;
    
}

?>