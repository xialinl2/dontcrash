<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */

define('DB_SERVER', 'localhost');
//define('DB_USERNAME', 'developer1');
//define('DB_PASSWORD', 'welcome123');
//define('DB_NAME', 'development1');

define('DB_USERNAME', 'dontcrash_dev');
define('DB_PASSWORD', 'thats2easy');
define('DB_NAME', 'dontcrash_db');
 
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>