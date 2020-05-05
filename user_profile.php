<?php

require 'connection.php';

if(!isset($_SESSION))
{
	session_start();
}

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

$GLOBALS['CURRENT_PAGE'] = "User Profile";

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
	   " AND ac.location_id = lc.location_id ".
     " AND ac.User ="."'".$_SESSION["username"]."'";
?>



<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="">
    <meta name="keywords" content="" />
    <title>User Profile</title>
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
		<style>
		    .sidebar-sticky {
		        padding-top: 20px;
                padding-left: 0px;
		    }
		    #footer {
              position: fixed;
              left: 0;
              bottom: 0;
              width: 100%;
            }

		</style>
  </head>
  <body>
    <!-- header -->
    <?php include "header.php"; ?>

    <!-- side bar -->
    <div class="container-fluid">
      <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
          <div class="sidebar-sticky">
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link active" href="profilexl.php">
                  Profile <span class="sr-only">(current)</span>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="report_form3.php">
                  Create Report
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="user_profile.php">
                  History Report
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="accident_alerts.php">
                  Accidents Alert
                </a>
              </li>
            </ul>

          </div>
        </nav>

        <!-- main -->
        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
          <h2>Historical Accident Reports</h2>
          <div class="table-responsive">
            <table class="table">
					  <thead>
  						<tr>
  						  <th scope="col">Record No</th>
  						  <th scope="col">Crash Date</th>
                <th scope="col">Location</th>
                <th scope="col">Street Name</th>
  						  <th scope="col">Weather</th>
  						  <th scope="col">Lighting</th>
  						  <th scope="col">Roadway Condition</th>
  						  <th scope="col">Damage</th>
  						  <th scope="col">Primary Cause</th>
								<th scope="col">Operation</th>
  						</tr>
					  </thead>
            <?php

            $result = $conn->query($sql);
          	echo '<tbody>';
          	if ($result->num_rows > 0)
            {
          		while($row = $result->fetch_assoc()) {
          			$record_no = $row["RD_NO"];
          			$crashDate = $row["CRASH_DATE"];
                    $location = $row["LOCATION"];
                    $streetName = $row["STREET_NAME"];
          			$wid = $row["WEATHER"];
          			$lid = $row["LIGHTING"];
          			$roadwayCond = $row["ROADWAY_SURFACE_COND"];
          			$damage = $row["DAMAGE"];
          			$primCause = $row["PRIM_CAUSE"];
          			echo '<tr>'.
          					'<td><a href="#">'.$record_no.'</a></td>'.
          					'<td>'.$crashDate.'</td>'.
                    '<td>'.$location.'</td>'.
                    '<td>'.$streetName.'</td>'.
          					'<td>'.$wid.'</td>'.
          					'<td>'.$lid.'</td>'.
          					'<td>'.$roadwayCond.'</td>'.
          					'<td>'.$damage.'</td>'.
          					'<td>'.$primCause.'</td>'.
                            '<td><a href="edit_form3.php?editrdno='.$record_no.'">Edit</a>'.
                            '&nbsp&nbsp;<a href="delete.php?RD_NO='.$record_no.'">Delete</a></td>'.
                  		'</tr>';
              }
          	}
          	else
            {
        			echo '<tr>'.
        					'<td  colspan="10" align="center">No records returned</td>'.
        				'</tr>';
          	}
          	echo '</tbody>';
          	$result->free();
          	$conn->close();

            ?>
          </table>
          </div>
        </main>
      </div>
    </div>

    <!-- Footer -->
    <?php include "footer.php"; ?>
  </body>

</html>
