<?php


if(!isset($_SESSION))
{
	session_start();
}

$GLOBALS['CURRENT_PAGE'] = "Accident Alerts";


?>




<?php
    
	//Database connection settings 
	require 'connection.php';
	
	$RD_NO = $_GET['RD_NO'];
	$username = $_GET['username'];
	

	//delete a record
	$sql = "UPDATE notification 
	    SET STATUS = 1 
        WHERE RD_NO='".$RD_NO."' 
        AND USERNAME ='".$username."'";
    
	if ($conn->query($sql) === TRUE) 
	{
        //return to the previous page
    	echo "<script>alert('Alert dismissed!' );location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
	}
	else {
		echo "Error deleting record: " . $conn->error;
	}
	$conn->close();
	
 ?>

