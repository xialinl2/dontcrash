<?php
require 'connection.php';
$severity = $_GET['severity'];
$result_array = array();
$sql = "SELECT cid, cause_desc FROM contributory_cause where severity='".$severity."'";
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
