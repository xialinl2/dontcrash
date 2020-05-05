<?php

require 'connection.php';

$GLOBALS['CURRENT_PAGE'] = "Accident Listing";

// Define variables and initialize with empty values
$rdno = $location = $dateFrom = $dateTo = $weather = $lighting = $primcause = $seccause = $dayofweek = $month = $hour = $injuriesfatal = "";
$no_of_params = 0;

$sql = "SELECT ac.RD_NO, DATE(ac.CRASH_DATE) CRASH_DATE, wc.weather WEATHER, lg.LIGHTING LIGHTING, ac.ROADWAY_SURFACE_COND, ac.CRASH_TYPE ".
	   ", ac.DAMAGE, cc1.CAUSE_DESC PRIM_CAUSE, cc2.CAUSE_DESC SEC_CAUSE, ac.STREET_NAME, ac.MOST_SEVERE_INJURY ".
	   ", ac.INJURIES_TOTAL, lc.COMMUNITY_AREA LOCATION, lc.COMMUNITY_SIDE SIDE ".
	   " FROM accidents ac ".
	   ", weather wc ".
	   ", light_condition lg ".
	   ", contributory_cause cc1 ".
	   ", contributory_cause cc2 ".
	   ", location lc ".
	   " WHERE 1=1 ".
	   " AND ac.wid = wc.wid ".
	   " AND ac.lid = lg.lid ".
	   " AND ac.PRIM_CONTRIBUTORY_CAUSE = cc1.cid ".
	   " AND ac.SEC_CONTRIBUTORY_CAUSE = cc2.cid ".
	   " AND ac.location_id = lc.location_id ";
$addWhere = "";

//Form Validation on POST
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$no_of_params = 0;	
	if(!empty($_POST['rdno'])){
		$rdno = trim($_POST["rdno"]);
		$addWhere = $addWhere." AND ac.RD_NO = '".$rdno."'";
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['location'])){
		$location = trim($_POST["location"]);
		$addWhere = $addWhere." AND lc.location_id = ".$location;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['dateFrom'])){
		$dateFrom = trim($_POST["dateFrom"]);
		$addWhere = $addWhere." AND DATE(ac.CRASH_DATE) >= STR_TO_DATE('".$dateFrom."', '%m/%d/%Y') ";
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['dateTo'])){
		$dateTo = trim($_POST["dateTo"]);
		$addWhere = $addWhere." AND DATE(ac.CRASH_DATE) <= STR_TO_DATE('".$dateTo."', '%m/%d/%Y') ";
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['weather'])){
		$weather = trim($_POST["weather"]);
		$addWhere = $addWhere." AND wc.wid = ".$weather;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['lighting'])){
		$lighting = trim($_POST["lighting"]);
		$addWhere = $addWhere." AND lg.lid = ".$lighting;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['primcause'])){
		$primcause = trim($_POST["primcause"]);
		$addWhere = $addWhere." AND cc1.cid = ".$primcause;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['damage'])){
		$damage = trim($_POST["damage"]);
		$addWhere = $addWhere." AND ac.DAMAGE = '".$damage."' ";
		$no_of_params = $no_of_params + 1;
	}	
	if(!empty($_POST['dayofweek'])){
		$dayofweek = trim($_POST["dayofweek"]);
		$addWhere = $addWhere." AND ac.CRASH_DAY_OF_WEEK = ".$dayofweek;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['month'])){
		$month = trim($_POST["month"]);
		$addWhere = $addWhere." AND ac.CRASH_MONTH = ".$month;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['hour'])){
		$hour = trim($_POST["hour"]);
		$addWhere = $addWhere." AND ac.CRASH_HOUR = ".$hour;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['injuriesfatal'])){
		$injuriesfatal = trim($_POST["injuriesfatal"]);
		$addWhere = $addWhere." AND ac.INJURIES_FATAL = ".$injuriesfatal;
		$no_of_params = $no_of_params + 1;
	}

	//echo $sql;
	
	/*
	echo $rdno.'<br>';
	echo $location.'<br>';
	echo $dateFrom.'<br>';
	echo $dateTo.'<br>';
	echo $weather.'<br>';
	echo $lighting.'<br>';
	echo $primcause.'<br>';
	//echo $seccause.'<br>';
	echo $damage.'<br>';
	echo $dayofweek.'<br>';
	echo $month.'<br>';
	echo $hour.'<br>';
	echo $injuriesfatal.'<br>';
	*/		

	//echo $no_of_params;
	if($no_of_params < 1){
		header('Location: accidents_search.php?error=Please enter at least 4 filters');
		exit();
	}
} 

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Generic</title>
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
					<ul><li><a href="accidents_search.php">Back to Search Page</a></li></ul>
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">Record No</th>
						  <th scope="col">Crash Date</th>
						  <th scope="col">Weather</th>
						  <th scope="col">Lighting</th>
						  <th scope="col">Roadway Condition</th>
						  <!--<th scope="col">Crash Type</th>-->
						  <th scope="col">Damage</th>
						  <th scope="col">Primary Cause</th>	
						  <!--<th scope="col">Secondary Cause</th>-->
						  <th scope="col">Street Name</th>
						  <!--<th scope="col">Injury</th>-->
						  <th scope="col">#Injuries</th>
						  <th scope="col">Location</th>
						  <!--<th scope="col">Side</th>-->
						</tr>
					  </thead>
					  
<?php

require 'connection.php';

if (isset($_GET['pageno'])) {
	$pageno = $_GET['pageno'];
	$addWhere = $_GET['ssql'];
	$no_of_params = 5;
} else {
	$pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;

$sql = $sql.$addWhere;

$total_pages_sql = "SELECT count(*) TOTALROWS FROM (".$sql.") a";
$result = $conn->query($total_pages_sql);
//echo $total_pages_sql;
$total_rows = 0;
while($row = $result->fetch_assoc()) {
	$total_rows = $row["TOTALROWS"];
}
$total_pages = ceil($total_rows / $no_of_records_per_page);
//echo $total_pages;

//Now set query per pagination
$lsql = $sql." LIMIT $offset, $no_of_records_per_page";
//echo $lsql;

if ($no_of_params > 0) {
	$result = $conn->query($lsql);
	
	echo '<tbody>';
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$record_no = $row["RD_NO"];
			$crashDate = $row["CRASH_DATE"];	
			$wid = $row["WEATHER"];
			$lid = $row["LIGHTING"];
			$roadwayCond = $row["ROADWAY_SURFACE_COND"];
			$crashType = $row["CRASH_TYPE"];	
			$damage = $row["DAMAGE"];
			$primCause = $row["PRIM_CAUSE"];	
			$secCause = $row["SEC_CAUSE"];
			$streetName = $row["STREET_NAME"];	
			$injury = $row["MOST_SEVERE_INJURY"];
			$totalInjury = $row["INJURIES_TOTAL"];	
			$location = $row["LOCATION"];
			$side = $row["SIDE"];	
			echo '<tr>'.
					'<td><a href="view_accident.php?editrdno='.$record_no.'">'.$record_no.'</a></td>'.
					'<td>'.$crashDate.'</td>'.
					'<td>'.$wid.'</td>'.
					'<td>'.$lid.'</td>'.
					'<td>'.$roadwayCond.'</td>'.
					//'<td>'.$crashType.'</td>'.
					'<td>'.$damage.'</td>'.
					'<td>'.$primCause.'</td>'.
					//'<td>'.$secCause.'</td>'.
					'<td>'.$streetName.'</td>'.
					//'<td>'.$injury.'</td>'.
					'<td>'.$totalInjury.'</td>'.
					'<td>'.$location.'</td>'.
					//'<td>'.$side.'</td>'.
				'</tr>';
		}
	}
	else {
			echo '<tr>'.
					'<td  colspan="10" align="center">No records returned</td>'.
				'</tr>';		
	}
	echo '</tbody>';
	$result->free();
	$conn->close();
}

?>					  
					</table>
					<nav id="nav">
					<ul class="pagination">
						<li class="<?php if($pageno == 1){ echo 'disabled'; } ?>"><a href="?pageno=1&ssql=<?php echo $addWhere; ?>">First</a></li>
						<li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
							<a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1)."&ssql=".$addWhere; } ?>">Prev</a>
						</li>
						<li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
							<a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1)."&ssql=".$addWhere; } ?>">Next</a>
						</li>
						<li class="<?php if($pageno == $total_pages){ echo 'disabled'; } ?>"><a href="?pageno=<?php echo $total_pages."&ssql=".$addWhere; ?>">Last</a></li>
					</ul>
					</nav>
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>