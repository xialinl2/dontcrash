<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>test</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
        <!--script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script -->	
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>

		<!-- Header -->
			<header id="header">
				<h1><a href="index.php">Accident Analysis</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="index.html">Home</a></li>
						<li><a href="generic.html">Generic</a></li>
						<li><a href="elements.html">Elements</a></li>
						<li><a href="#" class="button special">Sign Up</a></li>
					</ul>
				</nav>
			</header>

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>test</h2>
						<p>test</p>
					</header>



<?php
	/* Database connection settings */
	require 'connection.php';

	//query to get data from the table
	$sql = "SELECT LATITUDE,LONGITUDE,RD_NO FROM accidents limit 100";
    $result = $conn->query($sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		//$LATITUDE = $LATITUDE . '"'. $row['LATITUDE'].'",';
		//$LONGITUDE = $LONGITUDE . '"'. $row['LONGITUDE'].'",';
		//$RD_NO = $RD_NO . '"'. $row['RD_NO'].'",';
		$LATITUDE[] = $row['LATITUDE'];
		$LONGITUDE[] = $row['LONGITUDE'];
		$RD_NO[] =$row['RD_NO'];
	}


?>

<!DOCTYPE html>
<html>
	<head>
    	<!--meta name="viewport" content="width=device-width, initial-scale=1.0"-->
		<script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
		<script src="https://api.mapbox.com/mapbox-gl-js/v1.9.0/mapbox-gl.js"></script>

	</head>

	<body>	   
	    <div id="maptest" style="width:600px;height:250px;"></div>
	    <script>
			var data = [{
				type:'scattermapbox',
				//locationmode: 'geojson-id',
				//geojson: 'https://data.cityofchicago.org/api/geospatial/cauq-8yn6?method=export&format=GeoJSON'
				lat: ['41.831296077','42.012292006'],
				lon: ['-87.614925683','-87.683227658'],
				//hoverinfo:"text",
				text:  ['r1','r2'],
				mode: 'markers',
				marker: {
					size: 6,
					opacity: 0.7,
					//reversescale: true,
					//autocolorscale: true,
					//symbol: 'circle'
					//line: {
						//width: 1,
						//color: 'rgb(102,102,102)'
					//},
				}
			}];
			var layout = {
				title: 'crash',
				mapbox:{
					tyle:"dark",
					center: {lon: -87.623177, lat:41.881832},
					zoom:11
				},
				width:1500, height: 1000
			};
			var config = {mapboxAccessToken: "pk.eyJ1Ijoic2hlaWxhMDEyMWoiLCJhIjoiY2s4a3hycWdmMDNpcTNlbDMzeHBxaGthcSJ9.MVWI71kfFxtL_hfw3Z1Ntw"};
			Plotly.newPlot("maptest", data, layout,config);
		</script>
	    
	</body>
</html>