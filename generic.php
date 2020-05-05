<?php
$GLOBALS['CURRENT_PAGE'] = "Report Accidents";

if(!isset($_SESSION)) 
{ 
	session_start(); 
} 

// Check if the user is already logged in, or force login

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
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
						<p align="center">sfgsfghshg</p>
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Generic</h2>
						<p>Page header line</p>
					</header>

					<a href="#" class="image fit"><img src="images/pic07.jpg" alt="" /></a>
					<p>Description Here</p>

				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>