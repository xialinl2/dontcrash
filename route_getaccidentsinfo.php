<?php
require 'connection.php';
$lat = $_GET['lat'];
$long = $_GET['long'];
$result_array = array();
$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE latitude LIKE '".$lat."'% AND longitude LIKE'".$long."'%";
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
