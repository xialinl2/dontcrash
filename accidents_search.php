<?php

if(!isset($_SESSION))
{
	session_start();
}

$GLOBALS['CURRENT_PAGE'] = "Accident Search";
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Accidents Search</title>
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

// Define variables and initialize with empty values
$rdno = $location = $dateFrom = $dateTo = $weather = $lighting = $primcause = $seccause = $dayofweek = $month = $hour = $injuriesfatal = $damage = "";

//Get location
$sql = "SELECT location_id, community_area, community_side FROM location Order By 2";
$result = $conn->query($sql);
$location_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$location_select = '<select id="location" name="location" class="form-control"><option value="" selected>-select location-</option>'; 
	while($row = $result->fetch_assoc()) {
		$lid = $row["location_id"];
		$area = $row["community_area"];
		$community = $row["community_side"];
		$location_select = $location_select.'<option value="'.$lid.'">'.$area.'    -    '.$community.'</option>';
	}
	$result->free();
	$location_select = $location_select.'</select>';	
}

// Get weather condition
$sql = "SELECT wid, weather FROM weather Order By 1";
$result = $conn->query($sql);
$weather_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$weather_select = '<select id="weather" name="weather" class="form-control"><option value="" selected>-select weather-</option>'; 
	while($row = $result->fetch_assoc()) {
		$wid = $row["wid"];
		$weather = $row["weather"];
		$weather_select = $weather_select.'<option value="'.$wid.'">'.$weather.'</option>';
	}
	$result->free();
	$weather_select = $weather_select.'</select>';	
}

// Get lighting condition
$sql = "SELECT lid, lighting FROM light_condition Order By 1";
$result = $conn->query($sql);
$lighting_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$lighting_select = '<select id="lighting" name="lighting" class="form-control"><option value="" selected>-select lighting condition-</option>'; 
	while($row = $result->fetch_assoc()) {
		$lgid = $row["lid"];
		$lighting = $row["lighting"];
		$lighting_select = $lighting_select.'<option value="'.$lgid.'">'.$lighting.'</option>';
	}
	$result->free();
	$lighting_select = $lighting_select.'</select>';	
}

// Get contributory cause
$sql = "SELECT cid, cause_desc FROM contributory_cause Order By 2";
$result = $conn->query($sql);
$cause_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$cause_select1 = '<select id="primcause" name="primcause" class="form-control"><option value="" selected>-select primary cause-</option>'; 
	$cause_select2 = '<select id="seccause" name="seccause" class="form-control"><option value="" selected>-select secondary cause-</option>'; 
	while($row = $result->fetch_assoc()) {
		$cid = $row["cid"];
		$causedesc = $row["cause_desc"];
		$cause_select1 = $cause_select1.'<option value="'.$cid.'">'.$causedesc.'</option>';
		$cause_select2 = $cause_select2.'<option value="'.$cid.'">'.$causedesc.'</option>';
	}
	$result->free();
	$cause_select1 = $cause_select1.'</select>';
	$cause_select2 = $cause_select2.'</select>';	
}

$conn->close();

// Damage
$damage = '<select id="damage" name="damage" class="form-control"><option value="" selected>-select damage-</option>';
$damage = $damage.'<option value="$500 OR LESS">$500 OR LESS</option>'.'<option value="$501 - $1,500">$501 - $1,500</option>'.'<option value="OVER $1,500">OVER $1,500</option>';
$damage = $damage.'</select>';

// Crash Day
$crash_day = '<select id="dayofweek" name="dayofweek" class="form-control"><option value="" selected>-select day-</option>';
$crash_day = $crash_day.'<option value="1">Sunday</option>'.'<option value="2">Monday</option>'.'<option value="3">Tuesday</option>'.'<option value="4">Wednesday</option>';
$crash_day = $crash_day.'<option value="5">Thursday</option>'.'<option value="6">Friday</option>'.'<option value="7">Saturday</option>';
$crash_day = $crash_day.'</select>';

// Crash Month
$crash_month = '<select id="month" name="month" class="form-control"><option value="" selected>-select month-</option>';
$crash_month = $crash_month.'<option value="1">January</option>'.'<option value="2">February</option>'.'<option value="3">March</option>'.'<option value="4">April</option>';
$crash_month = $crash_month.'<option value="5">May</option>'.'<option value="6">June</option>'.'<option value="7">July</option>'.'<option value="8">August</option>';
$crash_month = $crash_month.'<option value="9">September</option>'.'<option value="10">October</option>'.'<option value="11">November</option>'.'<option value="12">December</option>';
$crash_month = $crash_month.'</select>';

// Crash Hour
$crash_hour = '<select id="hour" name="hour" class="form-control"><option value="" selected>-select hour-</option>';
$crash_hour = $crash_hour.'<option value="0">12 AM</option>'.'<option value="1">1 AM</option>'.'<option value="2">2 AM</option>'.'<option value="3">3 AM</option>';
$crash_hour = $crash_hour.'<option value="4">4 AM</option>'.'<option value="5">5 AM</option>'.'<option value="6">6 AM</option>'.'<option value="7">7 AM</option>';
$crash_hour = $crash_hour.'<option value="8">8 AM</option>'.'<option value="9">9 AM</option>'.'<option value="10">10 AM</option>'.'<option value="11">11 AM</option>';
$crash_hour = $crash_hour.'<option value="12">12 PM</option>'.'<option value="13">1 PM</option>'.'<option value="14">2 PM</option>'.'<option value="15">3 PM</option>';
$crash_hour = $crash_hour.'<option value="16">4 PM</option>'.'<option value="17">5 PM</option>'.'<option value="18">6 PM</option>'.'<option value="19">7 PM</option>';
$crash_hour = $crash_hour.'<option value="20">8 PM</option>'.'<option value="21">9 PM</option>'.'<option value="22">10 PM</option>'.'<option value="23">11 PM</option>';
$crash_hour = $crash_hour.'</select>';

// Crash Hour
$injuries_fatal = '<select id="injuriesfatal" name="injuriesfatal" class="form-control"><option value="" selected>-select injuries fatal-</option>';
$injuries_fatal = $injuries_fatal.'<option value="0">False</option>'.'<option value="1">True</option>';
$injuries_fatal = $injuries_fatal.'</select>';


?>		

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">							
				<form action="accidents_list.php" method="post">
<?php				
    if(!empty($_GET['error'])){
		echo '<p color="red">'.$_GET['error'].'</p>';
    }
?>	
				<table class="table">
				  <tbody>
					<tr>
					  <td>Record No:</td>
					  <td><input type="text" id="rdno" name="rdno" class="form-control" value=""></td>
					  <td>&nbsp;</td>
					  <td>Location:</td>
					  <td><?php echo $location_select; ?></td>
					</tr>
					<tr>
					  <td>Crash Date From:</td>
					  <td><input type="text" name="dateFrom" id="dateFrom" alt="date" class="IP_calendar" class="form-control" title="m/d/Y"></td>
					  <td>&nbsp;</td>
					  <td>Crash Date To:</td>
					  <td><input type="text" name="dateTo" id="dateTo" alt="date" class="IP_calendar" class="form-control" title="m/d/Y"></td>
					</tr>
					<tr>
					  <td>Weather Condition:</td>
					  <td><?php echo $weather_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Lighting Condition:</td>
					  <td><?php echo $lighting_select; ?></td>
					</tr>
					<tr>
					  <td>Primary Cause:</td>
					  <td><?php echo $cause_select1; ?></td>
					  <td>&nbsp;</td>
					  <td>Damage:</td>
					  <td><?php echo $damage; ?></td>
					</tr>
					<tr>
					  <td>Crash Day:</td>
					  <td><?php echo $crash_day; ?></td>
					  <td>&nbsp;</td>
					  <td>Crash Month:</td>
					  <td><?php echo $crash_month; ?></td>
					</tr>
					<tr>
					  <td>Crash Hour:</td>
					  <td><?php echo $crash_hour; ?></td>
					  <td>&nbsp;</td>
					  <td>Injuries Fatal:</td>
					  <td><?php echo $injuries_fatal; ?></td>
					</tr>					
				  </tbody>
				</table>
				<header class="major">					
					<div class="form-group">
						<input type="submit" class="button medium" value="Search Accidents">
						<input type="reset" class="button medium" value="Reset">
					</div>					
				</header>				
				</form>
				
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>			

