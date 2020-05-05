<?php
$GLOBALS['CURRENT_PAGE'] = "Report Accidents";
// Check if the user is already logged in, or force login
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Report Page</title>
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

set_time_limit(90); // this sets the time limit to fetch query, default 30 seconds

// Define variables and initialize with empty values
$tcd = $crashDate = $totalinjuries = $dc = $fct = $twt = $lanecnt = $alignment = $rsc = $crashtype = $msi = $location = $weather = $lighting = $primcause = $seccause = $policenotified = $psl = $hnr = $damage = $dayofweek = $month = $hour = $injuriesfatal = $streetname = "";

//Get traffic control device
$sql = "select distinct accidents.TRAFFIC_CONTROL_DEVICE from accidents Order By 1";
$result = $conn->query($sql);
$tcd_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$tcd_select = '<select id="tcd" name="tcd" class="form-control"><option value="" selected>-select device-</option>'; 
	while($row = $result->fetch_assoc()) {
		$tcd = $row["TRAFFIC_CONTROL_DEVICE"];
		$tcd_select = $tcd_select.'<option value="'.$tcd.'">'.$tcd.'</option>';
	}
	$result->free();
	$tcd_select = $tcd_select.'</select>';	
}

//Get device condition
$sql = "select distinct accidents.DEVICE_CONDITION from accidents Order By 1";
$result = $conn->query($sql);
$dc_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$dc_select = '<select id="dc" name="dc" class="form-control"><option value="" selected>-select device condition-</option>'; 
	while($row = $result->fetch_assoc()) {
		$dc = $row["DEVICE_CONDITION"];
		$dc_select = $dc_select.'<option value="'.$dc.'">'.$dc.'</option>';
	}
	$result->free();
	$dc_select = $dc_select.'</select>';	
}

//Get first crash type
$sql = "select distinct accidents.FIRST_CRASH_TYPE from accidents Order By 1";
$result = $conn->query($sql);
$fct_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$fct_select = '<select id="fct" name="fct" class="form-control"><option value="" selected>-select crash type-</option>'; 
	while($row = $result->fetch_assoc()) {
		$fct = $row["FIRST_CRASH_TYPE"];
		$fct_select = $fct_select.'<option value="'.$fct.'">'.$fct.'</option>';
	}
	$result->free();
	$fct_select = $fct_select.'</select>';	
}

//Get traffic way type
$sql = "select distinct accidents.TRAFFICWAY_TYPE from accidents Order By 1";
$result = $conn->query($sql);
$twt_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$twt_select = '<select id="twt" name="twt" class="form-control"><option value="" selected>-select way type-</option>'; 
	while($row = $result->fetch_assoc()) {
		$twt = $row["TRAFFICWAY_TYPE"];
		$twt_select = $twt_select.'<option value="'.$twt.'">'.$twt.'</option>';
	}
	$result->free();
	$twt_select = $twt_select.'</select>';	
}

//Get alignment
$sql = "select distinct accidents.ALIGNMENT from accidents Order By 1";
$result = $conn->query($sql);
$alm_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$alm_select = '<select id="alignment" name="alignment" class="form-control"><option value="" selected>-select alignment-</option>'; 
	while($row = $result->fetch_assoc()) {
		$alignment = $row["ALIGNMENT"];
		$alm_select = $alm_select.'<option value="'.$alignment.'">'.$alignment.'</option>';
	}
	$result->free();
	$alm_select = $alm_select.'</select>';	
}

//Get roadway surface condition
$sql = "select distinct accidents.ROADWAY_SURFACE_COND from accidents Order By 1";
$result = $conn->query($sql);
$rsc_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$rsc_select = '<select id="rsc" name="rsc" class="form-control"><option value="" selected>-select surface condition-</option>'; 
	while($row = $result->fetch_assoc()) {
		$rsc = $row["ROADWAY_SURFACE_COND"];
		$rsc_select = $rsc_select.'<option value="'.$rsc.'">'.$rsc.'</option>';
	}
	$result->free();
	$rsc_select = $rsc_select.'</select>';	
}

//Get crash type
$sql = "select distinct accidents.CRASH_TYPE from accidents Order By 1";
$result = $conn->query($sql);
$ct_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$ct_select = '<select id="crashtype" name="crashtype" class="form-control"><option value="" selected>-select crash type-</option>'; 
	while($row = $result->fetch_assoc()) {
		$crashtype = $row["CRASH_TYPE"];
		$ct_select = $ct_select.'<option value="'.$crashtype.'">'.$crashtype.'</option>';
	}
	$result->free();
	$ct_select = $ct_select.'</select>';	
}

//Get injury type
$sql = "select distinct accidents.MOST_SEVERE_INJURY from accidents Order By 1";
$result = $conn->query($sql);
$msi_select = "";
if ($result->num_rows > 0) {
	// output data of each row
	$msi_select = '<select id="msi" name="msi" class="form-control"><option value="" selected>-select injury type-</option>'; 
	while($row = $result->fetch_assoc()) {
		$msi = $row["MOST_SEVERE_INJURY"];
		$msi_select = $msi_select.'<option value="'.$msi.'">'.$msi.'</option>';
	}
	$result->free();
	$msi_select = $msi_select.'</select>';	
}

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

//Posted Speed Limit
$psl_select = "";
$psl_select = '<select id="psl" name="psl" class="form-control"><option value="" selected>-select speed limit-</option>';
$psl_select = $psl_select.'<option value="5">5 mph</option>'.'<option value="10">10 mph</option>'.'<option value="15">15 mph</option>'.'<option value="20">20 mph</option>';
$psl_select = $psl_select.'<option value="25">25 mph</option>'.'<option value="30">30 mph</option>'.'<option value="35">35 mph</option>';
$psl_select = $psl_select.'<option value="40">40 mph</option>'.'<option value="45">45 mph</option>'.'<option value="50">50 mph</option>';
$psl_select = $psl_select.'<option value="55">55 mph</option>'.'<option value="60">60 mph</option>'.'<option value="65">65 mph</option>';
$psl_select = $psl_select.'<option value="70">70 mph</option>'.'<option value="75">75 mph</option>'.'<option value="80">80 mph</option>';
$psl_select = $psl_select.'<option value="85">85 mph</option>'.'<option value="90">90 mph</option>'.'<option value="95">95 mph</option>';
$psl_select = $psl_select.'</select>';

//Hit And Run
$hnr_select = "";
$hnr_select = '<select id="hnr" name="hnr" class="form-control"><option value="" selected>-select-</option>';
$hnr_select = $hnr_select.'<option value="Y">Yes</option>'.'<option value="N">No</option>';
$hnr_select = $hnr_select.'</select>';

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

// Fatal Injuries
$injuries_fatal = '<select id="injuriesfatal" name="injuriesfatal" class="form-control"><option value="" selected>-select injuries fatal-</option>';
$injuries_fatal = $injuries_fatal.'<option value="0">False</option>'.'<option value="1">True</option>';
$injuries_fatal = $injuries_fatal.'</select>';

			
if(!empty($_GET['error'])){
	echo '<p align="center">'.$_GET['error'].'</p>';
}
if(!empty($_GET['newrdno'])){
	echo '<p align="center">Record No '.$_GET['newrdno'].' created successfully!</p>';
}	
?>	
		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">	
				<p> Input accident details below:
				<form action="insert_accident.php" method="post">

				<table class="table">
				  <tbody>
					<tr>
					  <td>Record No:</td>
					  <td><input type="text" id="rdno" name="rdno" class="form-control" value="" disabled></td>
					  <td>&nbsp;</td>
					  <td>Crash Date:</td>
					  <td><input type="text" name="crashDate" id="crashDate" alt="date" class="IP_calendar" class="form-control" title="Y-m-d"></td>
					</tr>
					<tr>
					  <td>Posted Speed Limit:</td>
					  <td><?php echo $psl_select; ?></td> 
					  <td>&nbsp;</td>
					  <td>Total Injuries:</td>
					  <td><input type="text" id="totalinjuries" name="totalinjuries" class="form-control" value=""></td>
					</tr>					
					<tr>
					  <td>Traffic Control Device:</td>
					  <td><?php echo $tcd_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Device Condition:</td>
					  <td><?php echo $dc_select; ?></td>
					</tr>
					<tr>
					  <td>Weather Condition:</td>
					  <td><?php echo $weather_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Lighting Condition:</td>
					  <td><?php echo $lighting_select; ?></td>
					</tr>
					<tr>
					  <td>First Crash Type:</td>
					  <td><?php echo $fct_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Traffic Way Type:</td>
					  <td><?php echo $twt_select; ?></td>
					</tr>
					<tr>
					  <td>Lane Count:</td>
					  <td><input type="text" id="lanecnt" name="lanecnt" class="form-control" value=""></td>
					  <td>&nbsp;</td>
					  <td>Alignment:</td>
					  <td><?php echo $alm_select; ?></td>
					</tr>
					<tr>
					  <td>Roadway Surface Condition:</td>
					  <td><?php echo $rsc_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Crash Type:</td>
					  <td><?php echo $ct_select; ?></td>
					</tr>
					<tr>
					  <td>Hit And Run:</td>
					  <td><?php echo $hnr_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Damage:</td>
					  <td><?php echo $damage; ?></td>
					</tr>
					<tr>
					  <td>Primary Cause:</td>
					  <td><?php echo $cause_select1; ?></td>
					  <td>&nbsp;</td>
					  <td>Secondary Cause:</td>
					  <td><?php echo $cause_select2; ?></td>
					</tr>
					<tr>
					  <td>Injury Type:</td>
					  <td><?php echo $msi_select; ?></td>
					  <td>&nbsp;</td>
					  <td>Injuries Fatal:</td>
					  <td><?php echo $injuries_fatal; ?></td>
					</tr>					
					<tr>
					  <td>Police Notified On:</td>
					  <td><input type="text" name="policenotified" id="policenotified" alt="date" class="IP_calendar" class="form-control" title="Y-m-d"></td>
					  <td>&nbsp;</td>
					  <td>Crash Hour:</td>
					  <td><?php echo $crash_hour; ?></td>
					</tr>
					<tr>
					  <td>Crash Day:</td>
					  <td><?php echo $crash_day; ?></td>
					  <td>&nbsp;</td>
					  <td>Crash Month:</td>
					  <td><?php echo $crash_month; ?></td>
					</tr>
					<tr>
					  <td>Street Name:</td>
					  <td><input type="text" id="streetname" name="streetname" class="form-control" value=""></td>
					  <td>&nbsp;</td>
					  <td>Location:</td>
					  <td><?php echo $location_select; ?></td>
					</tr>					
				  </tbody>
				</table>
				<header class="major">					
					<div class="form-group">
						<input type="submit" class="button medium" value="Report Accident">
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

