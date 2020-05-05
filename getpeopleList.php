<?php
require 'connection.php';
$PERSON_TYPE = $_GET['PERSON_TYPE'];
$result_array = array();
$sql = "SELECT pid, RD_NO, SEX, AGE, SAFETY_EQUIPMENT, DRIVER_ACTION, DRIVER_VISION FROM people where PERSON_TYPE='".$PERSON_TYPE."' and SEX IS NOT NULL and AGE IS NOT NULL limit 50";
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