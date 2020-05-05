<?php
require '../connection.php';
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
} 

/*if(!empty($_SESSION['username'])){
		$usern = $_SESSION['username'];
		$sql = $sql." AND USER = '".$usern."' " ;
	} else {
		header('Location: edit_form2.php?editrdno='.$rdno.'&error=User session is missing');
		exit();
	}*/

//$userId = $_GET['userId'];
$result_array = array();
$sql = "SELECT street_name,street_no,street_direction FROM dontcrash_db.accidents WHERE user='".$_SESSION["username"]."'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	    array_push($result_array, $row);
    }
    $result->free();
}

/* send a JSON encded array to client */
header('Content-type: application/json');
echo json_encode($result_array);
$conn->close();

?>	
