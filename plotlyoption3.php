<?php
$GLOBALS['CURRENT_PAGE'] = "Map";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Map of the Chicago Crash</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
        <!--script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script -->	
		<link href="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.css" rel="stylesheet" />
		<style>
		body { margin: 0; padding: 0; }
		#map { width: 100%; height: 80%}
		</style>
		<noscript>
			<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<style>
	.mapcontainer {
		height:100%;
	}
    </style>
	<body>

		<!-- Header -->
			<?php include "header.php"; ?>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">
				
				<header class="major">
					<h2>Distribution of Chicago Crash</h2>
				</header>
					
<?php
	/* Database connection settings */
	require 'connection.php';

	//query to get data from the table
	$sql = "SELECT LATITUDE,LONGITUDE,RD_NO FROM accidents where CRASH_DATE > '2019-01-01'";
    
	
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

	   
<div id="maptest" class="mapcontainer"></div>
			
			
			
<?php
//Get location
require 'connection.php';
$sql = "SELECT location_id, community_area, community_side FROM location Order By 3";
$result = $conn->query($sql);
$location_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$location_select = ''; 
	$i=0;
	$temp = 'Central';
	while($row = $result->fetch_assoc()) {
		if($i==0){
			$location_select=$location_select.'<table class="table"><tbody><tr><td colspan="9"><b>Central:</td></tr><tr>';
			$i++;}
		$lid = $row["location_id"];
		$area = $row["community_area"];
		$community = $row["community_side"];
		if($community!=$temp){
			$location_select=$location_select.'</tr><tr><td colspan="9"><b>'.$community.':</td></tr><tr>';
			$temp=$community;
			$i=1;
		}
		$location_select = $location_select.'<td><input type="checkbox" name="location[]" value="'.$lid.'" id="'.$lid.'"><label for="'.$lid.'">'.$area.'    -    '.$community.'</label></td>';
		if($i%5 == 0){
			$location_select=$location_select."</tr><tr>";
		}
		else
		{
			$location_select=$location_select."<td>&nbsp;</td>";
		}
		$i++;
	}
	$location_select=$location_select."</tr></tbody></table>";
	$result->free();
	//$location_select = $location_select.'</select>';	
}
 
?>
        	
					
				<form action="update_map2.php" method="post">  
<?php				
    if(!empty($_GET['error'])){
		echo '<p color="red">'.$_GET['error'].'</p>';
    }
?>					
				
					 <p>select community:</p>
					  <?php echo $location_select; ?>
					  
				<header class="major">					
					<div class="form-group">
						<input type="submit" class="button medium" value="Update Map">
						<input type="reset" class="button medium" value="Reset">
					</div>					
				</header>				
				</form>

				</div>
			</section>
		
		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
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
</html>