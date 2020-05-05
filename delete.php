<?php


if(!isset($_SESSION))
{
	session_start();
}

$GLOBALS['CURRENT_PAGE'] = "Accident Report";


?>




<?php
    
	//Database connection settings 
	require 'connection.php';
	
	$RD_NO = $_GET['RD_NO'];
	

	//delete a record
	$sql = "DELETE FROM accidents WHERE RD_NO='".$RD_NO."'";
	if ($conn->query($sql) === TRUE) {
    //return to the previous page
	echo "<script>alert('report deleted!' );location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
	}
	else {
		echo "Error deleting record: " . $conn->error;
	}
	$conn->close();
	
 ?>

