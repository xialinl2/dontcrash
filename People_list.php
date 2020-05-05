<?php

require 'connection.php';

$GLOBALS['CURRENT_PAGE'] = "People Listing";

// Define variables and initialize with empty values
$pid = $PERSON_TYPE = $RD_NO = $SEX = $AGE = "";
$no_of_params = 0;

$sql = "SELECT pid, RD_NO, SEX, AGE, SAFETY_EQUIPMENT, DRIVER_ACTION, DRIVER_VISION FROM people where 1=1";
$addWhere = "";

//Form Validation on POST
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$no_of_params = 0;	
	if(!empty($_POST['rdno'])){
		$rdno = trim($_POST["rdno"]);
		$addWhere = $addWhere." AND RD_NO = '".$rdno."'";
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['pid'])){
		$pid = trim($_POST["pid"]);
		$addWhere = $addWhere." AND pid = ".$pid;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['PERSON_TYPE'])){
		$PERSON_TYPE = trim($_POST["PERSON_TYPE"]);
		$addWhere = $addWhere." AND PERSON_TYPE = ".$PERSON_TYPE;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['SEX'])){
		$SEX = trim($_POST["SEX"]);
		$addWhere = $addWhere." AND SEX = ".$SEX;
		$no_of_params = $no_of_params + 1;
	}
	if(!empty($_POST['AGE'])){
		$AGE = trim($_POST["AGE"]);
		$addWhere = $addWhere." AND AGE = ".$AGE;
		$no_of_params = $no_of_params + 1;
	}	
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
		header('Location: peoplenew.php?error=Please enter at least 1 filters');
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
					<ul><li><a href="peoplenew.php">Back to Search Page</a></li></ul>
					<table class="table">
					  <thead>
						<tr>
						  <th scope="col">PID</th>
						  <th scope="col">RD_NO</th>
						  <th scope="col">Sex</th>
						  <th scope="col">Age</th>
						  <th scope="col">Safety Equipment</th>
						  <!--<th scope="col">Crash Type</th>-->
						  <th scope="col">Action</th>
						  <th scope="col">Vision</th>	
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
			$pid = $row["pid"];
			$RD_NO = $row["RD_NO"];	
			$SEX = $row["SEX"];
			$AGE = $row["AGE"];
			$SAFETY_EQUIPMENT = $row["SAFETY_EQUIPMENT"];
			$DRIVER_ACTION = $row["DRIVER_ACTION"];	
			$DRIVER_VISION = $row["DRIVER_VISION"];	
			echo '<tr>'.
					'<td>'.$pid.'</a></td>'.
					'<td><a href="#">'.$RD_NO.'</td>'.
					'<td>'.$SEX.'</td>'.
					'<td>'.$AGE.'</td>'.
					'<td>'.$SAFETY_EQUIPMENT.'</td>'.
					//'<td>'.$crashType.'</td>'.
					'<td>'.$DRIVER_ACTION.'</td>'.
					'<td>'.$DRIVER_VISION.'</td>'.
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