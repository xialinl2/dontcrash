<?php

if(!isset($_SESSION))
{
	session_start();
}
$GLOBALS['CURRENT_PAGE'] = "Update Accident";
set_time_limit(90); // this sets the time limit to fetch query, default 30 seconds

// Define variables and initialize with empty values
$rdno = $editrdno = $stno = $stname = $stdir = $rddef = $tcd = $crashDate = $totalinjuries = $dc = $fct = $twt = $lanecnt = $alignment = $rsc = $crashtype = $msi = $location = $weather = $lighting = $primcause = $seccause = $policenotified = $psl = $hnr = $damage = $injuriesfatal = "";

$no_of_params = 0;
$sql = "UPDATE `accidents` SET ";

//Form Validation on POST
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$no_of_params = 0;
	if(!empty($_POST['stno'])){
		$stno = trim($_POST["stno"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql."STREET_NO = ".$stno." " ;
	} else {
		$sql = $sql."STREET_NO = NULL ";
	}
	if(!empty($_POST['stname'])){
		$stname = trim($_POST["stname"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", STREET_NAME = '".$stname."' " ;
	} else {
		$sql = $sql.", STREET_NAME = NULL ";
	}
	if(!empty($_POST['stdir'])){
		$stdir = trim($_POST["stdir"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", STREET_DIRECTION = '".$stdir."' " ;
	} else {
		$sql = $sql.", STREET_DIRECTION = NULL ";
	}	
	if(!empty($_POST['rddef'])){
		$rddef = trim($_POST["rddef"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ROAD_DEFECT = '".$rddef."' " ;
	} else {
		$sql = $sql.", ROAD_DEFECT = NULL ";
	}
	if(!empty($_POST['crashDate'])){
		$crashDate = trim($_POST["crashDate"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", CRASH_DATE = '".$crashDate."' " ;
	} else {
		$sql = $sql.", CRASH_DATE = NULL ";
	}
	if(!empty($_POST['psl'])){
		$psl = trim($_POST["psl"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", POSTED_SPEED_LIMIT = ".$psl." " ;
	} else {
		$sql = $sql.", POSTED_SPEED_LIMIT = NULL ";
	}
	if(!empty($_POST['tcd'])){
		$tcd = trim($_POST["tcd"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", TRAFFIC_CONTROL_DEVICE = '".$tcd."' " ;
	} else {
		$sql = $sql.", TRAFFIC_CONTROL_DEVICE = NULL ";
	}	
	if(!empty($_POST['dc'])){
		$dc = trim($_POST["dc"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", DEVICE_CONDITION = '".$dc."' " ;
	} else {
		$sql = $sql.", DEVICE_CONDITION = NULL ";
	}
	if(!empty($_POST['weather'])){
		$weather = trim($_POST["weather"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", WID = ".$weather." " ;
	} else {
		$sql = $sql.", WID = NULL ";
	}
	if(!empty($_POST['lighting'])){
		$lighting = trim($_POST["lighting"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", LID = ".$lighting." " ;
	} else {
		$sql = $sql.", LID = NULL ";
	}	
	if(!empty($_POST['fct'])){
		$fct = trim($_POST["fct"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", FIRST_CRASH_TYPE = '".$fct."' " ;
	} else {
		$sql = $sql.", FIRST_CRASH_TYPE = NULL ";
	}
	if(!empty($_POST['twt'])){
		$twt = trim($_POST["twt"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", TRAFFICWAY_TYPE = '".$twt."' " ;
	} else {
		$sql = $sql.", TRAFFICWAY_TYPE = NULL ";
	}
	if(!empty($_POST['lanecnt'])){
		$lanecnt = trim($_POST["lanecnt"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", LANE_CNT = '".$lanecnt."' " ;
	} else {
		$sql = $sql.", LANE_CNT = NULL ";
	}
	if(!empty($_POST['alignment'])){
		$alignment = trim($_POST["alignment"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ALIGNMENT = '".$alignment."' " ;
	} else {
		$sql = $sql.", ALIGNMENT = NULL ";
	}
	if(!empty($_POST['rsc'])){
		$rsc = trim($_POST["rsc"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ROADWAY_SURFACE_COND = '".$rsc."' " ;
	} else {
		$sql = $sql.", ROADWAY_SURFACE_COND = NULL ";
	}
	if(!empty($_POST['crashtype'])){
		$crashtype = trim($_POST["crashtype"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", CRASH_TYPE = '".$crashtype."' " ;
	} else {
		$sql = $sql.", CRASH_TYPE = NULL ";
	}
	if(!empty($_POST['hnr'])){
		$hnr = trim($_POST["hnr"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", HIT_AND_RUN_I = '".$hnr."' " ;
	} else {
		$sql = $sql.", HIT_AND_RUN_I = NULL ";
	}
	if(!empty($_POST['damage'])){
		$damage = trim($_POST["damage"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", DAMAGE = '".$damage."' " ;
	} else {
		$sql = $sql.", DAMAGE = NULL ";
	}	
	if(!empty($_POST['policenotified'])){
		$policenotified = trim($_POST["policenotified"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", DATE_POLICE_NOTIFIED = '".$policenotified."' " ;
	} else {
		$sql = $sql.", DATE_POLICE_NOTIFIED = NULL ";
	}
	if(!empty($_POST['primcause'])){
		$primcause = trim($_POST["primcause"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", PRIM_CONTRIBUTORY_CAUSE = ".$primcause." " ;
	} else {
		$sql = $sql.", PRIM_CONTRIBUTORY_CAUSE = NULL ";
	}
	if(!empty($_POST['seccause'])){
		$seccause = trim($_POST["seccause"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", SEC_CONTRIBUTORY_CAUSE = ".$seccause." " ;
	} else {
		$sql = $sql.", SEC_CONTRIBUTORY_CAUSE = NULL ";
	}		
	if(!empty($_POST['msi'])){
		$msi = trim($_POST["msi"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", MOST_SEVERE_INJURY = '".$msi."' " ;
	} else {
		$sql = $sql.", MOST_SEVERE_INJURY = NULL ";
	}
	if(!empty($_POST['totalinjuries'])){
		$totalinjuries = trim($_POST["totalinjuries"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", INJURIES_TOTAL = ".$totalinjuries." " ;
	} else {
		$sql = $sql.", INJURIES_TOTAL = NULL ";
	}
	if(!empty($_POST['injuriesfatal'])){
		$injuriesfatal = trim($_POST["injuriesfatal"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", INJURIES_FATAL = ".$injuriesfatal." " ;
	} else {
		$sql = $sql.", INJURIES_FATAL = NULL ";
	}
	if(!empty($_POST['location'])){
		$location = trim($_POST["location"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", LOCATION_ID = ".$location." " ;
	} else {
		$sql = $sql.", LOCATION_ID = NULL ";
	}
	
	// If this one fails, we do not update anything
	if(!empty($_POST['rdno'])){
		$rdno = trim($_POST["rdno"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql." WHERE RD_NO = '".$rdno."' " ;
	} else {
		header('Location: edit_form2.php?editrdno='.$rdno.'&error=Record No is missing');
		exit();
	}
	if(!empty($_SESSION['username'])){
		$usern = $_SESSION['username'];
		$sql = $sql." AND USER = '".$usern."' " ;
	} else {
		header('Location: edit_form2.php?editrdno='.$rdno.'&error=User session is missing');
		exit();
	}

	//echo $sql;
	//echo $no_of_params;
	if($no_of_params < 3){
		header('Location: edit_form2.php?editrdno='.$rdno.'&error=Some values missing');
		exit();
	}

}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Report Accident</title>
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

<?php
require 'connection.php';
//echo $sql;
$output = "";

if ($conn->query($sql) === TRUE) {
	$output = " updated successfully";
} else {
	$output = " update error";
}
$conn->close();
header('Location: edit_form2.php?editrdno='.$rdno.'&error=Updated Successfully');
exit();


?>
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>
