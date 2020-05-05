 <?php
	/* Database connection settings */
	require 'connection.php';
	$GLOBALS['CURRENT_PAGE'] = "Map";
	//query to get data from the table
	$sql = "SELECT ac.LATITUDE,ac.LONGITUDE,ac.RD_NO FROM accidents ac, location lc where 1=1 AND ac.location_id = lc.location_id";
    $addWhere = "";
    $location = "";
	
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$no_of_params = 0;
	if(!empty($_POST['location'])){
		$selectedlocationCount = count($_POST['location']);
		$i = 0;
		while ($i < $selectedlocationCount) {
        if ($i == 0)
		{$addWhere = $addWhere." AND (lc.location_id = ".$_POST['location'][$i];}
		else
		{$addWhere = $addWhere." OR lc.location_id = ".$_POST['location'][$i];}
		if ($i == $selectedlocationCount-1) {
          $addWhere = $addWhere.")";
        }
        $i ++;
        }
		echo $addWhere;
		$no_of_params = $no_of_params + 1;
	}
	if($no_of_params < 1){
		header('Location: update_map.php?error=Please enter a filter');
		exit();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Generic</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>		
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>

		<!-- Header -->
		<?php include "header.php"; ?>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">
					<ul><li><a href="plotlyoption3.php">Back</a></li></ul>
					
<?php

	require 'connection.php';
	
	$sql = $sql.$addWhere;
	//echo $sql;
	$result = $conn->query($sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		$LATITUDE = $LATITUDE . '"'. $row['LATITUDE'].'",';
		$LONGITUDE = $LONGITUDE . '"'. $row['LONGITUDE'].'",';
		$RD_NO = $RD_NO . '"'. $row['RD_NO'].'",';
	}
	$LATITUDE = "[" . rtrim($LATITUDE,","). "]";
	$LONGITUDE = "[" . rtrim($LONGITUDE,","). "]";
	$RD_NO = "[" . rtrim($RD_NO,","). "]";

?>


<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>

	   
<div id="maptest" class="container" ></div>
<script>
	var data = [{
		type:'scattermapbox',
		//locationmode: 'geojson-id',
		//geojson: 'https://data.cityofchicago.org/api/geospatial/cauq-8yn6?method=export&format=GeoJSON'
		lon: <?php echo $LONGITUDE; ?>,
		lat: <?php echo $LATITUDE; ?>,
		//hoverinfo:"text",
		text:  <?php echo $RD_NO; ?>,
		mode: 'markers',
		marker: {
			size: 10,
			opacity: 0.8,
			//reversescale: true,
			//autocolorscale: true,
			symbol: 'circle'
			//line: {
				//width: 1,
				//color: 'rgb(102,102,102)'
			//},
		}
	}];
	var layout = {
		mapbox:{
			center: {lon: -87.623177, lat:41.881832},
			zoom:10
		},
		height: 800
	};
	var config = {responsive: true, mapboxAccessToken: "pk.eyJ1Ijoic2hlaWxhMDEyMWoiLCJhIjoiY2s4a3hycWdmMDNpcTNlbDMzeHBxaGthcSJ9.MVWI71kfFxtL_hfw3Z1Ntw"};
	Plotly.newPlot("maptest", data, layout,config);
</script>

		<!-- Footer -->
		<?php include "footer.php"; ?>
	</body>
</html>