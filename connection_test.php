<?php
$servername = "localhost";
$username = "dontcrash_dev";
$password = "thats2easy";

try {
    $conn = new PDO("mysql:host=$servername;dbname=h_db, $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
