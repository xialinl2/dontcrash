<?php
$GLOBALS['CURRENT_PAGE'] = "People Details";
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
		<title>Peoples Page</title>
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
$sql = "SELECT distinct PERSON_TYPE FROM people";
$result = $conn->query($sql);
echo '<div class="content">';
echo '<table border="1" cellspacing="2" cellpadding="2" class="content"> <tr>';
echo '<td align="left"><b>Please select the type of person to get more information: </b></td>';
if ($result->num_rows > 0) {
	// output data of each row
	echo '<td td align="left"><select id="PERSON_TYPE" name="PERSON_TYPE" onchange="getpeopleList(this.value)"><option selected>-select type of person-</option>'; 
 
	while($row = $result->fetch_assoc()) {
		$PERSON_TYPE = $row["PERSON_TYPE"];
	    echo '<option>'.$PERSON_TYPE.'</option>';
	}
	$result->free();
	echo '</select></td>'; 	
}
echo '</table> </tr>';

?>

<!--<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>-->
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<script type="text/javascript"> 
	function getpeopleList(selectedVal){ 
      $.ajax({ 
        method: "GET", 
		dataType: "json",        
        url: "getpeopleList.php",
		data: {PERSON_TYPE : selectedVal},
		success: function(JSONObject) {
        var string='<table border="1" cellspacing="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" cellpadding="2" class="content"><tr><td> <b> <font face="Arial">PID</font> </b></td><td> <b> <font face="Arial">RD_NO</font> </b></td> <td> <b> <font face="Arial">Sex</font> </b></td><td> <b> <font face="Arial">Age</font> </b></td> <td> <b> <font face="Arial">Safety Equipment</font> </b></td> <td> <b> <font face="Arial">Action</font> </b></td> <td> <b> <font face="Arial">Vision</font> </b></td></tr>';			
		  var peopleHTML = "";

		  // Loop through Object and create peopleHTML
		  for (var key in JSONObject) {
			if (JSONObject.hasOwnProperty(key)) {
			  peopleHTML += "<tr>";
				peopleHTML += "<td>" + JSONObject[key]["pid"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["RD_NO"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["SEX"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["AGE"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["SAFETY_EQUIPMENT"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["DRIVER_ACTION"] + "</td>";
				peopleHTML += "<td>" + JSONObject[key]["DRIVER_VISION"] + "</td>";
				
			  peopleHTML += "</tr>";
			}
		  }

		 string += peopleHTML;
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