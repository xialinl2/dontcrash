<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Weahter Condition</title>
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
						<h2>Weather Condition</h2>
						<p>Pie Chart for different weather condition</p>
					</header>

<?php
	/* Database connection settings */
	require 'connection.php';

	//query to get data from the table
	$sql = "SELECT count(*) as count FROM accidents group by WID order by WID";
    $result = $conn->query($sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {

		$count = $count . '"'. $row['count'].'",';
		
	}


?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<title>Weather pie chart</title>

		<!--style type="text/css">			
			body{
				font-family: Arial;
			    margin: 80px 100px 10px 100px;
			    padding: 0;
			    color: white;
			    text-align: center;
			    background: #FFFFFF;
			}

			.container {
				margin: 30px 30px 30px 30px;
				color: #FFFFFF;
				background: #FFFFFF;
				border: #555652 1px solid;
				padding: 10px;
			}
		</style-->

	</head>

	<body>	   
	    <div class="container">	
	    <!--h1>Weather condition</h1-->       
			<canvas id="chart" style="width: 100%; height: 70vh; background: #FFFFFF;"></canvas>

			<script>
				var ctx = document.getElementById("chart").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'doughnut',
		        data: {
		            labels: ['snow','unknown','clear','cloudy/overcast','rain','other','sleet/hail','fog/smoke/haze','severe cross wind gate'],
		            datasets: 
		            [{
		                data: [<?php echo $count; ?>],
		                backgroundColor: ['#A5DEE4','#c295d8','#effcef','#fe9801','#ff7272','#E2943B','#A28C37','#fbcffc','#cbe2b0'],
		                borderColor:'rgba(255,99,132)',
		                borderWidth: 2
		            }]
		        }
		     
		       
		    });
			</script>
	    </div>
	    
	</body>
</html>