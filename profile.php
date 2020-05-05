<!DOCTYPE html>
<html>
  <head>
    <title>Profile</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="routefinderassets/profile.css">
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
  <body>

	<!-- Header -->
	<?php include "header.php"; ?>
	<h2 class="textformat">Profile</h2>
	

	<div class="row textformat">
  <div class="column"> 
        <h2>Reported Accidents</h2>
	    <p class = 'psize' id = 'numAccidents'>0</p>
  </div>
  <div class="column"> 
  	<h2 id = 'mostRecent'>Most Recent Post</h2>
	<p class = 'psize' id = 'strRecent'>Most Recent Street</p>
  </div>
</div>
	<!--h2>Current Alerts</h2-->
    <div id="map"></div>
      
    <script src="jquery/jquery.js"></script>
    <!--"position:absolute;bottom:0px;height:50%;width:100%;"-->
    <script src="routefinderassets/profile.js" type="text/javascript"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCnDD1rNUQA_hXanSo4W6vXye8zw3Z0M7U&libraries=places&callback=initMap"
    type="text/javascript">initMap()</script>
    <!--script>initMap()</script-->
    		<!-- Footer -->
	<?php include "footer.php"; ?>
  </body>
</html>