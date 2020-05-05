<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
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
						<h2>Map of the Chicago Crash</h2>
						<p>Map of the Chicago Crash in 2019</p>
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

	   
<div id="maptest"></div>
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
		width:1200, height: 1100
	};
	var config = {mapboxAccessToken: "pk.eyJ1Ijoic2hlaWxhMDEyMWoiLCJhIjoiY2s4a3hycWdmMDNpcTNlbDMzeHBxaGthcSJ9.MVWI71kfFxtL_hfw3Z1Ntw"};
	Plotly.newPlot("maptest", data, layout,config);
</script>
	   

				</div>
			</section>
		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>	