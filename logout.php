<?php
// Initialize the session
if(!isset($_SESSION)) 
{ 
	session_start(); 
} 
 
// Unset all of the session variables
$_SESSION = array();
 
// remove all session variables
session_unset();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>