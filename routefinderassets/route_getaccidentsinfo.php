<?php
require '../connection.php';
$start_lats = $_POST['start_lats'];
$start_longs = $_POST['start_longs'];
$end_lats = $_POST['end_lats'];
$end_longs = $_POST['end_longs'];
$streets = $_POST['streets'];

$result_array = array();
$each_result_arr = array(); 
#$sql = "SELECT street_name FROM accidents WHERE latitude LIKE '".$lat."'%% AND longitude LIKE'".$long."'%%";

for($i = 0; $i < count($streets); $i++){
    $curr_start_lat = $start_lats[$i];
    $curr_start_long = $start_longs[$i];
    $curr_end_lat = $end_lats[$i];
    $curr_end_long = $end_longs[$i];
    $curr_street = $streets[$i];
    
    //$sql = "SELECT rd_no,street_name,latitude,longitude FROM dontcrash_db.accidents WHERE CAST(latitude AS DOUBLE) >= '".$curr_start_lat."' AND CAST(latitude AS DOUBLE) <= ".$curr_end_lat." AND CAST(longitude AS DOUBLE) >= ".$curr_start_long." AND CAST(longitude AS DOUBLE) <= ".$curr_end_long." AND street_name LIKE '%".$curr_street."%'";
//$sql = "SELECT rd_no,street_name,latitude,longitude FROM dontcrash_db.accidents WHERE CAST(latitude AS DOUBLE) >= ".$curr_start_lat." AND CAST(latitude AS DOUBLE) <= ".$curr_end_lat." AND street_name LIKE '%".$curr_street."%'";
//$sql = "SELECT CAST(latitude AS DOUBLE(8,4)),CAST(longitude AS DOUBLE(9,4)),street_name FROM dontcrash_db.accidents WHERE street_name LIKE '%PRINCETON%' AND CAST(latitude AS DOUBLE(8,4)) >= '41.1000' AND CAST(latitude AS DOUBLE(8,4)) <= '42.9000' AND CAST(longitude AS DOUBLE(9,4)) >= '-87.6350' AND CAST(longitude AS DOUBLE(9,4)) <= '-87.6300'";
//$sql = "SELECT CAST(latitude AS DOUBLE(7,2)),CAST(longitude AS DOUBLE(8,2)),street_name FROM dontcrash_db.accidents WHERE street_name LIKE '%".$curr_street."%' AND CAST(latitude AS DOUBLE(7,2)) >= CAST('".$curr_start_lat."' DOUBLE(7,2)) AND CAST(latitude AS DOUBLE(7,2)) <= CAST('".$curr_end_lat."' AS DOUBLE(7,2)) AND CAST(longitude AS DOUBLE(8,2)) >= CAST('".$curr_start_long."' AS DOUBLE(8,2)) AND CAST(longitude AS DOUBLE(8,2)) <= CAST('".$curr_end_long."' AS DOUBLE(8,2))";

$sql = "SELECT latitude,longitude,street_name FROM dontcrash_db.accidents WHERE (CAST(latitude AS DOUBLE(7,3)) BETWEEN '".$curr_start_lat."' AND '".$curr_end_lat."' AND CAST(longitude AS DOUBLE(8,3)) BETWEEN '".$curr_start_long."' AND '".$curr_end_long."')";
// street_name LIKE '%".$curr_street."%' AND
//$sql = "SELECT rd_no,street_name,latitude,longitude FROM dontcrash_db.accidents WHERE latitude >= '".$curr_start_lat."' AND latitude <= ".$curr_end_lat." AND longitude >= ".$curr_start_long." AND longitude <= ".$curr_end_long." AND street_name LIKE '%".$curr_street."%'";

    //$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE latitude BETWEEN '".$curr_start_lat."' AND '".$curr_end_lat."' AND longitude BETWEEN '".$curr_start_long."' AND '".$curr_end_long."' AND street_name LIKE '".$curr_street."%'";
    //$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE CAST(latitude AS DOUBLE) BETWEEN 41.850480000000005 AND 41.85094 AND CAST(longitude AS DOUBLE) BETWEEN -87.63474000000001 AND -87.63476000000001 AND street_name LIKE 'PRINCETON%'";
    //$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE latitude LIKE '".$currLat."%' AND longitude LIKE '".$currLong."%'";
    //$sql = "SELECT rd_no,street_name,latitude,longitude FROM dontcrash_db.accidents WHERE latitude LIKE '41.920%' AND longitude LIKE '-87.734%'";
//$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE latitude LIKE '41.850%' AND longitude LIKE '-87.634%' AND street_name LIKE 'PRINCETON%'";

//$sql = "SELECT rd_no,street_name,latitude,longitude FROM accidents WHERE latitude LIKE '41.850%' AND longitude LIKE '-87.634%' AND street_name LIKE 'PRINCETON%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
	    // output data of each row
	    while($row = $result->fetch_assoc()) {
	        array_push($each_result_arr, $row);
	    }
	    $result->free();
	    array_push($result_array, $each_result_arr);
	    //$each_result_arr->free();
    }
    else {
        array_push($result_array,'');
    }
}
/* send a JSON encded array to client */
header('Content-type: application/json');
echo json_encode($result_array);

$conn->close();
?>	
