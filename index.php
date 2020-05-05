<?php

if(!isset($_SESSION))
{
	session_start();
}

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
		<title>Traffic Accidents Analysis</title>
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
			<link rel="stylesheet" href="css/customStyle.css" />			
		</noscript>
	</head>
	<body class="landing">

		<!-- Header -->
		<?php include "header.php"; ?>

		<!-- Banner -->
			<section id="banner">
				<h2>Welcome to Accident Analysis Portal</h2>
				<p>In depth analysis of past traffic accidents in Chicago metropolitan area!</p>
				<ul class="actions">
					<li>
						<a href="./accidents_search.php" class="button big">Accident Insights</a>
					</li>
				</ul>
			</section>

		<!-- One -->
			<section id="one" class="wrapper style1 special">
				<div class="container">
					<header class="major">
						<h2>Accident Analysis of past accidents</h2>
						<p>To Give more insights to the accident prone locations, weather conditions and other factors</p>
					</header>
					<div class="row 150%">
						<div class="4u 12u$(medium)">
							<section class="box">
								<a href="chart_display.php"><i class="icon big rounded color1 fa-cloud"></i></a>
								<h3>Effects of Weather Conditions</h3>
								<p>Analyse the relations between traffic crashes and weather conditions.</p>								

							</section>
						</div>
						<div class="4u 12u$(medium)">
							<section class="box">
								<a href="chart_display.php"><i class="icon big rounded color9 fa-desktop"></i></a>
								<h3>Effects of Lighting Conditions</h3>
								<p>Analyse the relations between traffic crashes and lighting conditions.</p>
							</section>
						</div>
						<div class="4u$ 12u$(medium)">
							<section class="box">
								<a href="chart_display.php"><i class="icon big rounded color6 fa-rocket"></i></a>
								<h3>Other causes of Crashes</h3>
								<p>Analyse the relations between traffic crashes and the causes associated.</p>								
							</section>
						</div>
					</div>
				</div>
			</section>

		<!-- Three -->
			<section id="three" class="wrapper style3 special">
				<div class="container">
					<header class="major">
						<h2>Contact us</h2>
						<p>Please contact us filling the form below. Our team will get back to you in 24 hours!</p>
					</header>
				</div>
				<div class="container 50%">
					<form action="#" method="post">
						<div class="row uniform">
							<div class="6u 12u$(small)">
								<input name="name" id="name" value="" placeholder="Name" type="text">
							</div>
							<div class="6u$ 12u$(small)">
								<input name="email" id="email" value="" placeholder="Email" type="email">
							</div>
							<div class="12u$">
								<textarea name="message" id="message" placeholder="Message" rows="6"></textarea>
							</div>
							<div class="12u$">
								<ul class="actions">
									<li><input value="Send Message" class="special big" type="submit"></li>
								</ul>
							</div>
						</div>
					</form>
				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>