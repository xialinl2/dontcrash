<?php
require 'connection.php';
$model = $_GET['model'];
$result_array = array();
$sql = "SELECT vid, maneuver, crash_date, first_contact_point, vehicle_type, vehicle_use, unit_type, vehicle_year FROM vehicles where model='".$model."'";
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
