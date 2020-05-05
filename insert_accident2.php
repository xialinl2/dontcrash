<?php

require 'connection.php';

if(!isset($_SESSION))
{
	session_start();
}

$GLOBALS['CURRENT_PAGE'] = "Accident Report";

// Define variables and initialize with empty values
$stno = $stname = $stdir = $rddef = $tcd = $crashDate = $totalinjuries = $dc = $fct = $twt = $lanecnt = $alignment = $rsc = $crashtype = $msi = $location = $weather = $lighting = $primcause = $seccause = $policenotified = $psl = $hnr = $damage = $injuriesfatal = "";

$no_of_params = 0;

$sql = "INSERT INTO ".
		"`accidents`(`STREET_NO`,`STREET_NAME`,`STREET_DIRECTION`,`ROAD_DEFECT`, `CRASH_DATE`,`POSTED_SPEED_LIMIT`,`TRAFFIC_CONTROL_DEVICE`, ".
		"`DEVICE_CONDITION`,`WID`,`LID`,`FIRST_CRASH_TYPE`,`TRAFFICWAY_TYPE`,`LANE_CNT`,`ALIGNMENT`,`ROADWAY_SURFACE_COND`,`CRASH_TYPE`, ".
		"`HIT_AND_RUN_I`,`DAMAGE`,`DATE_POLICE_NOTIFIED`,`PRIM_CONTRIBUTORY_CAUSE`,`SEC_CONTRIBUTORY_CAUSE`, `MOST_SEVERE_INJURY`, ".
		"`INJURIES_TOTAL`,`INJURIES_FATAL`,`LOCATION_ID`,`USER`) VALUES ( ";

$addWhere = "";


//Form Validation on POST
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$no_of_params = 0;
	if(!empty($_POST['stno'])){
		$stno = trim($_POST["stno"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql."'".$stno."'" ;
	} else {
		$sql = $sql."NULL" ;
	}
	if(!empty($_POST['stname'])){
		$stname = trim($_POST["stname"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$stname."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['stdir'])){
		$stdir = trim($_POST["stdir"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$stdir."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['rddef'])){
		$rddef = trim($_POST["rddef"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$rddef."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['crashDate'])){
		$crashDate = trim($_POST["crashDate"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$crashDate."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['psl'])){
		$psl = trim($_POST["psl"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$psl."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['tcd'])){
		$tcd = trim($_POST["tcd"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$tcd."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['dc'])){
		$dc = trim($_POST["dc"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$dc."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['weather'])){
		$weather = trim($_POST["weather"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$weather ;
	} else {
		$sql = $sql.", 102" ;
	}
	if(!empty($_POST['lighting'])){
		$lighting = trim($_POST["lighting"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$lighting ;
	} else {
		$sql = $sql.", 94" ;
	}
	if(!empty($_POST['fct'])){
		$fct = trim($_POST["fct"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$fct."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['twt'])){
		$twt = trim($_POST["twt"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$twt."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['lanecnt'])){
		$lanecnt = trim($_POST["lanecnt"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$lanecnt ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['alignment'])){
		$alignment = trim($_POST["alignment"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$alignment."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['rsc'])){
		$rsc = trim($_POST["rsc"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$rsc."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['crashtype'])){
		$crashtype = trim($_POST["crashtype"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$crashtype."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['hnr'])){
		$hnr = trim($_POST["hnr"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$hnr."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['damage'])){
		$damage = trim($_POST["damage"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$damage."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['policenotified'])){
		$policenotified = trim($_POST["policenotified"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$policenotified."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['primcause'])){
		$primcause = trim($_POST["primcause"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$primcause ;
	} else {
		$sql = $sql.", 991" ;
	}
	if(!empty($_POST['seccause'])){
		$seccause = trim($_POST["seccause"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$seccause ;
	} else {
		$sql = $sql.", 991" ;
	}
	if(!empty($_POST['msi'])){
		$msi = trim($_POST["msi"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", '".$msi."'" ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['totalinjuries'])){
		$totalinjuries = trim($_POST["totalinjuries"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$totalinjuries ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['injuriesfatal'])){
		$injuriesfatal = trim($_POST["injuriesfatal"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$injuriesfatal ;
	} else {
		$sql = $sql.", NULL" ;
	}
	if(!empty($_POST['location'])){
		$location = trim($_POST["location"]);
		$no_of_params = $no_of_params + 1;
		$sql = $sql.", ".$location ;
	} else {
		$sql = $sql.", 78" ;
	}
	// User
	$sql = $sql.", '".$_SESSION["username"]."'";
	//$sql = $sql.", 'test12'";
	$sql = $sql." ) ";

	echo $sql;
	/*
	echo '&nbsp;&nbsp;&nbsp;'.'tcd : '. $tcd.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'crashDate : '. $crashDate.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'totalinjuries : '. $totalinjuries.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'dc : '. $dc.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'fct : '. $fct.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'twt : '. $twt.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'lanecnt : '. $lanecnt.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'alignment : '. $alignment.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'rsc : '. $rsc.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'crashtype : '. $crashtype.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'msi : '. $msi.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'location : '. $location.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'weather : '. $weather.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'lighting : '. $lighting.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'primcause : '. $primcause.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'seccause : '. $seccause.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'policenotified : '. $policenotified.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'psl : '. $psl.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'hnr : '. $hnr.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'damage : '. $damage.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'dayofweek : '. $dayofweek.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'month : '. $month.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'hour : '. $hour.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'injuriesfatal : '. $injuriesfatal.'<br>';
	echo '&nbsp;&nbsp;&nbsp;'.'streetname : '. $streetname.'<br>';

	//echo $no_of_params;
	if($no_of_params < 1){
		header('Location: report.php?error=Please enter required input');
		exit();
	}
	*/
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
set_time_limit(90); // this sets the time limit to fetch query, default 30 seconds

$result = "";

if ($conn->query($sql) === TRUE) {
	$result = "New record created successfully";
} else {
	$result = "Error: " .$conn->error;
	header('Location: report_form2.php?error='.$result);
	exit();
}

$rdsql = "select MAX(RD_NO) newrdno from accidents WHERE RD_NO like 'NW%%' AND user='".$_SESSION["username"]."'";
$result = $conn->query($rdsql);
$newrdno = "";
while($row = $result->fetch_assoc()) {
	$newrdno = $row["newrdno"];
}
header('Location: report_form2.php?newrdno='.$newrdno);
exit();
$result->free();
$conn->close();

?>
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>
