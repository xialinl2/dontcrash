<?php
$GLOBALS['CURRENT_PAGE'] = "Accident Charts";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Accidents Chart</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
		<script type="text/javascript" src="http://services.iperfect.net/js/IP_generalLib.js">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>			
        <!--script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script -->
		<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
		<script>
		 google.charts.load('current', {'packages':['corechart']});
			 // Draw the pie chart when Charts is loaded.
			  google.charts.setOnLoadCallback(draw_my_chart);
			  // Callback that draws the pie chart
			  function draw_my_chart() {
				// Create the data table .
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'weather');
				data.addColumn('number', 'accidentcount');
				for(i = 0; i < my_2d.length; i++)
			data.addRow([my_2d[i][0], parseInt(my_2d[i][1])]);
		// above row adds the JavaScript two dimensional array data into required chart format
			var options = {title:'Accident data chart based on weather',
							   width:700,
							   height:450};

				// Instantiate and draw the chart
				var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			  }
		</script>	

		<script>
		 google.charts.load('current', {'packages':['corechart']});
			 // Draw the pie chart when Charts is loaded.
			  google.charts.setOnLoadCallback(draw_my_chart1);
			  // Callback that draws the pie chart
			  function draw_my_chart1() {
				// Create the data table .
				var data1 = new google.visualization.DataTable();
				data1.addColumn('string', 'lighting');
				data1.addColumn('number', 'accidentcount');
				for(i = 0; i < my_2d1.length; i++)
			data1.addRow([my_2d1[i][0], parseInt(my_2d1[i][1])]);
		// above row adds the JavaScript two dimensional array data into required chart format
			var options1 = {title:'Accident data chart based on lighting',
							   width:700,
							   height:450};

				// Instantiate and draw the chart
				var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
				chart1.draw(data1, options1);
			  }
		</script>
		<noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
	</head>
	<body>
		<!-- Header -->
		<?php include "header.php"; ?>
		
		
<?php
	// Getting all param values
	require 'connection.php';

	//Get location
	$sql = "SELECT we.weather, count(ac.rd_no) accidentcount FROM weather we, accidents ac WHERE 1=1 AND ac.wid = we.WID GROUP BY we.wid ";
	$result = $conn->query($sql);
	// echo "No of records : ".$result->num_rows."<br>";
	$php_data_array = Array(); // create PHP array

	$data_table = "<table class='table'><tr><th>Weather</th><th>Accident Count</th></tr>";
	while($row = $result->fetch_row()) {
		//$weather = $row["weather"];
		//$accidentcount = $row["accidentcount"];
		//$data_table = $data_table."<tr><td>".$weather."</td><td>".$accidentcount."</td></tr>";
		$data_table = $data_table."<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
		$php_data_array[] = $row; // Adding to array
	}
	$data_table = $data_table."</table>";
	$result->free();	
	//$conn->close();
	
	//Transferring data from PHP to JavaScript to crate the chart
	echo "<script> var my_2d = ".json_encode($php_data_array)."</script>";	
	
	
	//Get location
	$sql = "SELECT lc.lighting, count(ac.rd_no) accidentcount1 from light_condition lc, accidents ac WHERE 1=1 AND ac.lid = lc.lid GROUP BY lc.lid ";
	$result = $conn->query($sql);
	// echo "No of records : ".$result->num_rows."<br>";
	$php_data_array1 = Array(); // create PHP array

	$data_table1 = "<table class='table'><tr><th>Lighting</th><th>Accident Count</th></tr>";
	while($row = $result->fetch_row()) {
		//$weather = $row["weather"];
		//$accidentcount = $row["accidentcount"];
		//$data_table = $data_table."<tr><td>".$weather."</td><td>".$accidentcount."</td></tr>";
		$data_table = $data_table."<tr><td>".$row[0]."</td><td>".$row[1]."</td></tr>";
		$php_data_array1[] = $row; // Adding to array
	}
	$data_table1 = $data_table1."</table>";
	$result->free();	
	$conn->close();
	
	//Transferring data from PHP to JavaScript to crate the chart
	echo "<script> var my_2d1 = ".json_encode($php_data_array1)."</script>";		
?>		

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">							
<?php				
    if(!empty($_GET['error'])){
		echo '<p color="red">'.$_GET['error'].'</p>';
    }
?>	
				<table class="table">
				  <tbody>
					<tr>
						<td><div id="chart_div"></div></td>
						<td><div id="chart_div1"></div></td>
					</tr>
				  </tbody>
				</table>
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>			
