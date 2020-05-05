<?php

$servername = "localhost";
$username = "dontcrash_dev";
$password = "thats2easy";
$dbname = "dontcrash_db";

//$username = "developer1";
//$password = "welcome123";
//$dbname = "development1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
//$conn = new mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
//else {
//     echo "Connected successfully";
//}

?>
