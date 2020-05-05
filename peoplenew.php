<?php
$GLOBALS['CURRENT_PAGE'] = "People Search";
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>People Search</title>
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
$pid = $PERSON_TYPE = $RD_NO = $SEX = $AGE = "";


// get person type
$sql = "SELECT distinct PERSON_TYPE FROM people Order By 1";
$result = $conn->query($sql);
$type_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$type_select = '<select id="PERSON_TYPE" name="PERSON_TYPE" class="form-control"><option value="" selected>-select person type-</option>'; 
	while($row = $result->fetch_assoc()) {
		$PERSON_TYPE = $row["PERSON_TYPE"];
		$type_select = $type_select.'<option>'.$PERSON_TYPE.'</option>';
	}
	$result->free();
	$type_select = $type_select.'</select>';	
}

// get sex
$sql = "SELECT distinct SEX FROM people where SEX IS NOT NULL Order By 1";
$result = $conn->query($sql);
$SEX_select = "";

if ($result->num_rows > 0) {
	// output data of each row
	$SEX_select = '<select id="SEX" name="SEX" class="form-control"><option value="" selected>-select sex-</option>'; 
	while($row = $result->fetch_assoc()) {
		$SEX = $row["SEX"];
		$SEX_select = $SEX_select.'<option>'.$SEX.'</option>';
	}
	$result->free();
	$SEX_select = $SEX_select.'</select>';	
}

$conn->close();

?>		

		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">							
				<form action="People_list.php" method="post">
<?php				
    if(!empty($_GET['error'])){
		echo '<p color="red">'.$_GET['error'].'</p>';
    }
?>	
				<table class="table">
				  <tbody>
					<tr>
					  <td>Pid:</td>
					  <td><input type="text" id="pid" name="pid" class="form-control" value=""></td>
					</tr>
					<tr>
					  <td>Person Type:</td>
					  <td><?php echo $type_select; ?></td>
					</tr>
					<tr>
					  <td>RD_NO:</td>
					  <td><input type="text" id="rdno" name="rdno" class="form-control" value=""></td>
					</tr>
					<tr>
					  <td>Sex:</td>
					  <td><?php echo $SEX_select; ?></td>
					</tr>
					<tr>
					  <td>Age:</td>
					  <td><input type="text" id="AGE" name="AGE" class="form-control" value=""></td>
					</tr>				
				  </tbody>
				</table>
				<header class="major">					
					<div class="form-group">
						<input type="submit" class="button medium" value="Search People">
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

