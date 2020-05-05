<?php
$GLOBALS['CURRENT_PAGE'] = "View Accident";
// Check if the user is already logged in, or force login
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>View Traffic Report</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/skel.min.js"></script>
	<script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <noscript>
			<link rel="stylesheet" href="css/skel.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-xlarge.css" />
		</noscript>
  </head>
  <body>
    <!-- header -->
    <!-- Header -->
		<?php include "header.php"; ?>

    <?php
    // Getting all param values
    require 'connection.php';
    set_time_limit(90); // this sets the time limit to fetch query, default 30 seconds
	$editrdno = "";
    if(!empty($_GET['editrdno'])){
    	$editrdno = $_GET['editrdno'];
    } 
	//else {
	//	header('Location: report.php?error='.$result);
	//	exit();		
	//}	
	
	$rddef_array = array('NO DEFECTS', 'WORN SURFACE', 'DEBRIS ON ROADWAY', 'RUT, HOLES', 'UNKNOWN');
	$psl_array = array('5', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55', '60', '65', '70', '75', '80', '85', '90', '95');
	$stdir_array = array('N', 'W', 'E', 'S');
	$yn_array = array('Y', 'N');
	
	// Define variables and initialize with empty values
    $rdno = $crashdate = $stno = $stname = $stdir = $rddef = $tcd = $crashDate = $totalinjuries = $dc = $fct = $twt = $lanecnt = $alignment = $rsc = $crashtype = $msi = $location = $weather = $lighting = $primcause = $seccause = $policenotified = $psl = $hnr = $damage = $policenotified = $injuriesfatal = "";
	
	
    // Define all edit variables
	$rdno_s = $crashdate_s = $psl_s = $tcd_s = $dc_s = $wid_s = $lgid_s = $fct_s = $twt_s = $lanecnt_s = $alignment_s = $rsc_s = $rddef_s = $crashtype_s = $hnr_s = $damage_s = $policenotified_s = $primcause_s = $seccause_s = $stno_s = $stname_s = $stdir_s = $msi_s = $totalinjuries_s = $injuriesfatal_s = $lid_s = "";	
	
    //Get full record details
    $sql = "SELECT RD_NO, CRASH_DATE, POSTED_SPEED_LIMIT, TRAFFIC_CONTROL_DEVICE, DEVICE_CONDITION, WID, LID, FIRST_CRASH_TYPE, TRAFFICWAY_TYPE,".
		   "LANE_CNT, ALIGNMENT, ROADWAY_SURFACE_COND, ROAD_DEFECT, CRASH_TYPE, HIT_AND_RUN_I, DAMAGE, DATE_POLICE_NOTIFIED, PRIM_CONTRIBUTORY_CAUSE, ".
		   "SEC_CONTRIBUTORY_CAUSE, STREET_NO, STREET_DIRECTION, STREET_NAME, MOST_SEVERE_INJURY, INJURIES_TOTAL, INJURIES_FATAL, LOCATION_ID, USER ".
		   "FROM accidents WHERE 1=1 AND RD_NO = '".$editrdno."' ";
	//echo $sql;
    $result = $conn->query($sql);
	//echo 'No of rows: '.$result->num_rows;
    if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
			$rdno_s = $row["RD_NO"];
			$crashdate_s = $row["CRASH_DATE"];
			if ($crashdate_s !== "") { $crashdate_s = date("Y-m-d", strtotime($crashdate_s))."T00:00"; }
			$psl_s = $row["POSTED_SPEED_LIMIT"];
			$tcd_s = $row["TRAFFIC_CONTROL_DEVICE"];
			$dc_s = $row["DEVICE_CONDITION"];
			$wid_s = $row["WID"];
			$lgid_s = $row["LID"];			
			$fct_s = $row["FIRST_CRASH_TYPE"];
			$twt_s = $row["TRAFFICWAY_TYPE"];
			$lanecnt_s = $row["LANE_CNT"];
			$alignment_s = $row["ALIGNMENT"];
			$rsc_s = $row["ROADWAY_SURFACE_COND"];
			$rddef_s = $row["ROAD_DEFECT"];
			$crashtype_s = $row["CRASH_TYPE"];
			$hnr_s = $row["HIT_AND_RUN_I"];
			$damage_s = $row["DAMAGE"];
			$policenotified_s = $row["DATE_POLICE_NOTIFIED"];
			if ($policenotified_s !== "") { $policenotified_s = date("Y-m-d", strtotime($policenotified_s))."T00:00"; }
			$primcause_s = $row["PRIM_CONTRIBUTORY_CAUSE"];
			$seccause_s = $row["SEC_CONTRIBUTORY_CAUSE"];
			$stno_s = $row["STREET_NO"];
			$stname_s = $row["STREET_NAME"];
			$stdir_s = $row["STREET_DIRECTION"];
			$msi_s = $row["MOST_SEVERE_INJURY"];
			$totalinjuries_s = $row["INJURIES_TOTAL"];
			$injuriesfatal_s = $row["INJURIES_FATAL"];
			$lid_s = $row["LOCATION_ID"];
    	}
    	$result->free();

		/*
		echo $rdno_s.': RD_NO</br>';
		echo $crashdate_s.': CRASH_DATE</br>';
		echo $psl_s.': POSTED_SPEED_LIMIT</br>';
		echo $tcd_s.': TRAFFIC_CONTROL_DEVICE</br>';
		echo $dc_s.': DEVICE_CONDITION</br>';
		echo $wid_s.': WID</br>';
		echo $lgid_s.': LID</br>';			
		echo $fct_s.': FIRST_CRASH_TYPE</br>';
		echo $twt_s.': TRAFFICWAY_TYPE</br>';
		echo $lanecnt_s.': LANE_CNT</br>';
		echo $alignment_s.': ALIGNMENT</br>';
		echo $rsc_s.': ROADWAY_SURFACE_COND</br>';
		echo $rddef_s.': ROAD_DEFECT</br>';
		echo $crashtype_s.': CRASH_TYPE</br>';
		echo $hnr_s.': HIT_AND_RUN_I</br>';
		echo $damage_s.': DAMAGE</br>';
		echo $policenotified_s.': DATE_POLICE_NOTIFIED</br>';
		echo $primcause_s.': PRIM_CONTRIBUTORY_CAUSE</br>';
		echo $seccause_s.': SEC_CONTRIBUTORY_CAUSE</br>';
		echo $stno_s.': STREET_NO</br>';
		echo $stname_s.': STREET_NAME</br>';
		echo $stdir_s.': STREET_DIRECTION</br>';
		echo $msi_s.': MOST_SEVERE_INJURY</br>';
		echo $totalinjuries_s.': INJURIES_TOTAL</br>';
		echo $injuriesfatal_s.': INJURIES_FATAL</br>';
		echo $lid_s.': LOCATION_ID</br>';
		*/		

    } 
	else {
		//close connection and redirect back
	}
	
    //Get location
    $sql = "SELECT location_id, community_area, community_side FROM location where location_id =".$lid_s."";
    $result = $conn->query($sql);
    $location_select = "";

    if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
    		$lid = $row["location_id"];
    		$area = $row["community_area"];
    		$community = $row["community_side"];
			if ($lid == $lid_s) {
				$location_select = $location_select.
				'<input type="text" id="location" name="location" class="form-control" value="'.$area.'-'.$community.'" disabled></input>';
			}		
    	}
    	$result->free();
    }

    // Get weather condition
    $sql = "SELECT wid, weather FROM weather WHERE wid=".$wid_s;
    $result = $conn->query($sql);
    $weather_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
    		$wid = $row["wid"];
    		$weather = $row["weather"];
			if ($wid == $wid_s) {
				$weather_select = $weather_select.
				'<input type="text" id="weather" name="weather" class="form-control" value="'.$weather.'" disabled></input>';				
			}		
    	}
    	$result->free();
    }	
	
    // Get lighting condition
    $sql = "SELECT lid, lighting FROM light_condition WHERE lid=".$lgid_s;
    $result = $conn->query($sql);
    $lighting_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
    		$lgid = $row["lid"];
    		$lighting = $row["lighting"];
    		
			if ($lgid == $lgid_s) {
				$lighting_select = $lighting_select.
				'<input type="text" id="lighting" name="lighting" class="form-control" value="'.$lighting.'" disabled></input>';
			}		
    	}
    	$result->free();
    	$lighting_select = $lighting_select.'</select>';
    }	
	
    $sql = "SELECT cid, cause_desc FROM contributory_cause WHERE cid IN (".$primcause_s." , ".$seccause_s.")";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
    	// output data of each row
    	while($row = $result->fetch_assoc()) {
    		$cid = $row["cid"];
    		$causedesc = $row["cause_desc"];
			if ($cid == $primcause_s) {
				$cause_select1 = $cause_select1.
				'<input type="text" id="primcause" name="primcause" class="form-control" value="'.$causedesc.'" disabled></input>';
			}
			
			if ($cid == $seccause_s) {
				$cause_select2 = $cause_select2.
				'<input type="text" id="seccause" name="seccause" class="form-control" value="'.$causedesc.'" disabled></input>';
			}			
    	}
    	$result->free();
    }	
	
    $conn->close();
?>	
	
    <!-- main -->
    <div class="container">
      <h1>View Traffic Report</h1>
      <h5>Contributing to Safer Roads in Chicago
	  <div align="right"><a href="javascript:history.go(-1)"><b>Return to Accident Lists</b></a></div></h5>
			
	  <form action="#" method="post">

	      <div class="accordion" id="accordionExample">
	        <div class="card">
	          <div class="card-header" id="headingOne">
	            <h2 class="mb-0">
	              <button class="btn btn-link" type="button" data-toggle="collapse show" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
	                Date and Location of occurrence
	              </button>
	            </h2>
	          </div>		  
	          <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
	            <div class="card-body">
	              <div class="row">
	                <div class="col-md-2">
	                  <label> Record No. </label>
	                  <input type="text" id="rdno1" name="rdno1" class="form-control" value="<?php echo $rdno_s; ?>" disabled></input>
					  <input type="hidden" id="rdno" name="rdno" value="<?php echo $rdno_s; ?>"></input>
	                </div>
	                <div class="col-md-2">
	                  <label> Street No. </label>
	                  <input type="text" id="stno" name="stno"class="form-control"  value="<?php echo $stno_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> Street Name </label>
	                  <input type="text" id="stname" name="stname" class="form-control" value="<?php echo $stname_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-2">
	                  <label> Street Direction </label>
					  <input type="text" id="stdir" name="stdir" class="form-control" value="<?php echo $stdir_s; ?>" disabled></input>
	                </div>
	              </div>
	              <br>
	              <div class="row form-group">
	                <div class="col-md-6">
	                  <label> Community </label>
	                  <?php echo $location_select; ?>
	                </div>
									<div class="col-md-6">
										<label> Posted Speed Limit </label>
										<input type="text" id="psl" name="psl" class="form-control" value="<?php echo $psl_s; ?> mph" disabled></input>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-6">
										<label> Crash Datetime </label>
										<input type="datetime-local" id="crashDate" name="crashDate" class="form-control" value="<?php echo $crashdate_s; ?>" disabled></input>
									</div>
									<div class="col-md-6">
										<label> Police Notice Datetime </label>
										<input type="datetime-local" id="policenotified" name="policenotified" class="form-control" value="<?php echo $policenotified_s; ?>" disabled></input>
									</div>
	              </div>

	              <label> Traffic Control Device </label>
	              <input type="text" id="tcd" name="tcd" class="form-control" value="<?php echo $tcd_s; ?>" disabled></input>
	              <br>
	              <label> Device Conditions </label>
				  <input type="text" id="dc" name="dc" class="form-control" value="<?php echo $dc_s; ?>" disabled></input>
	            </div>
	          </div>
	        </div>

	        <div class="card">
	          <div class="card-header" id="headingTwo">
	            <h2 class="mb-0">
	              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
	                Environment Conditions
	              </button>
	            </h2>
	          </div>
	          <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
	            <div class="card-body">
	              <div class="row">
	                <div class="col-md-6">
	                  <label> Weather Condition </label>
	                  <?php echo $weather_select; ?>
	                </div>
	                <div class="col-md-6">
	                  <label> Lighting Condition </label>
	                  <?php echo $lighting_select; ?>
	                </div>
	                <div class="col-md-4">
	                  <label> Traffic Way Type </label>
					  <input type="text" id="tw" name="tw" class="form-control" value="<?php echo $twt_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-4">
	                  <label> Lane Count </label>
	                  <input type="number" class="form-control" name="lanecnt" value="<?php echo $lanecnt_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-4">
	                  <label> Alignment </label>
					  <input type="text" class="form-control" name="alignment" value="<?php echo $alignment_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> Roadway Surface Condition </label>
					  <input type="text" class="form-control" name="rsc" value="<?php echo $rsc_s; ?>" disabled></input>
	                  </select>
	                </div>
	                <div class="col-md-6">
	                  <label> Road Defect </label>
					  <input type="text" class="form-control" name="rddef" value="<?php echo $rddef_s; ?>" disabled></input>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	        <div class="card">
	          <div class="card-header" id="headingThree">
	            <h2 class="mb-0">
	              <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
	                Accident Consequeses
	              </button>
	            </h2>
	          </div>
	          <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
	            <div class="card-body">
	              <div class="row">
	                <div class="col-md-6">
	                  <label> Crash Type </label>
					  <input type="text" class="form-control" name="crashtype" value="<?php echo $crashtype_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> Damage </label>
					  <input type="text" class="form-control" name="damage" value="<?php echo $damage_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-4">
	                  <label>  Most Severe Injury </label>
					  <input type="text" class="form-control" name="msi" value="<?php echo $msi_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-4">
	                  <label> Fatal Injury </label>
	                  <input type="text" id="injuriesfatal" name="injuriesfatal" class="form-control" value="<?php echo $injuriesfatal_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-4">
	                  <label> Total Injury </label>
	                  <input type="text" id="totalinjuries" name="totalinjuries" class="form-control" value="<?php echo $totalinjuries_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> First Crash Type </label>
					  <input type="text" class="form-control" name="fct" value="<?php echo $fct_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> Hit and Run </label>
					  <input type="text" class="form-control" name="hnr" value="<?php echo $hnr_s; ?>" disabled></input>
	                </div>
	                <div class="col-md-6">
	                  <label> Primay Cause </label>
	                  <?php echo $cause_select1; ?>
	                </div>
	                <div class="col-md-6">
	                  <label> Secondary Cause </label>
	                  <?php echo $cause_select2; ?>
	                </div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
				<div>
					<p>&nbsp;</p>
				</div>		  
				<div class="form-group">
					<input type="submit" class="button medium" value="Return to Accident Search">
				</div>
			</form>
    </div>
  </br>
    <!-- Footer -->
		<?php include "footer.php"; ?>
  </body>

  </body>
</html>