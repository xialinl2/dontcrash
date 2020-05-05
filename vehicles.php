<?php
$GLOBALS['CURRENT_PAGE'] = "Vehicle Details";
?>
<!DOCTYPE html>
<!--
	Transit by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Vehicles Page</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
		<script src="js/jquery.min.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
		<script src="js/init.js"></script>
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

<?php
require 'connection.php';
$sql = "SELECT distinct model FROM vehicles ORDER BY model ASC";
$result = $conn->query($sql);
echo '<div class="content">';
echo '<table border="1" cellspacing="2" cellpadding="2" class="content"> <tr>';
echo '<td align="left"><b>Please select the car model to get details on vehicles involved in accidents: </b></td>';
if ($result->num_rows > 0) {
	// output data of each row
	echo '<td td align="left"><select id="model" name="model" onchange="getCauses(this.value)"><option selected>-select model-</option>'; 
    /*for ($x = 0; $x <= 20; $x++) {
        $row = $result->fetch_assoc();
        $model = $row["model"];
	    echo '<option>'.$model.'</option>';
    }*/
	while($row = $result->fetch_assoc()) {
		$model = $row["model"];
	    echo '<option>'.$model.'</option>';
	}
	$result->free();
	echo '</select></td>'; 	
}
echo '</table> </tr>';

?>

<!--<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>-->
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type="text/javascript"> 
	function getCauses(selectedVal){ 
      $.ajax({ 
        method: "GET", 
		dataType: "json",        
        url: "getvehicleinfo.php",
		data: {model : selectedVal},
		success: function(JSONObject) {
        var string='<table border="1" cellspacing="2"  cellspacing="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" class="content"><tr><td> <b> <font face="Arial">VID</font> </b></td><td> <b> <font face="Arial">Crash Date</font> </b></td> <td> <b> <font face="Arial">Maneuver</font> </b></td><td> <b> <font face="Arial">First Contact Point</font> </b></td> <td> <b> <font face="Arial">Vehicle Type</font> </b></td> <td> <b> <font face="Arial">Vehicle Use</font> </b></td> <td> <b> <font face="Arial">Unit Type</font> </b></td> <td> <b> <font face="Arial">Model Year</font> </b></td></tr>';			
		  var vehicleHTML = "";

		  // Loop through Object and create maneuverHTML
		  for (var key in JSONObject) {
			if (JSONObject.hasOwnProperty(key)) {
			  vehicleHTML += "<tr>";
				vehicleHTML += "<td>" + JSONObject[key]["vid"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["crash_date"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["maneuver"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["first_contact_point"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["vehicle_type"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["vehicle_use"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["unit_type"] + "</td>";
				vehicleHTML += "<td>" + JSONObject[key]["vehicle_year"] + "</td>";
			  vehicleHTML += "</tr>";
			}
		  }

		 string += vehicleHTML;
		 string += '</table>'; 
          $("#records").html(string); 
		}
		});	
    }; 
</script> 	
<div id="records">
records will show here
</div> 				

				</div>
			</section>
		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>	

