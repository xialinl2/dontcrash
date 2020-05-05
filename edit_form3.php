<?php
$GLOBALS['CURRENT_PAGE'] = "Update Accident";
// Check if the user is already logged in, or force login
if(!isset($_SESSION)) 
{ 
	session_start(); 
}

if(!isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Edit Traffic Report</title>
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
		   "FROM accidents WHERE 1=1 AND RD_NO = '".$editrdno."' AND USER = '".$_SESSION["username"]."'";
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
	
    //Get traffic control device
    $sql = "select distinct accidents.TRAFFIC_CONTROL_DEVICE from accidents Order By 1";
    $result = $conn->query($sql);
    $tcd_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$tcd_select = '<select id="tcd" name="tcd" class="form-control"><option value="" style=\'display:none;\'>Please Choose</option>';
    	while($row = $result->fetch_assoc()) {
    		$tcd = $row["TRAFFIC_CONTROL_DEVICE"];
			if ($tcd == $tcd_s) {
				$tcd_select = $tcd_select.'<option value="'.$tcd.'" selected>'.$tcd.'</option>';
			} else {
				$tcd_select = $tcd_select.'<option value="'.$tcd.'">'.$tcd.'</option>';	
			}
    	}
    	$result->free();
    	$tcd_select = $tcd_select.'</select>';
    }	
	
    //Get device condition
    $sql = "select distinct accidents.DEVICE_CONDITION from accidents Order By 1";
    $result = $conn->query($sql);
    $dc_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$dc_select = '<select id="dc" name="dc" class="form-control"><option value="" style=\'display:none;\'>Please Choose</option>';
    	while($row = $result->fetch_assoc()) {
    		$dc = $row["DEVICE_CONDITION"];
			if ($dc == $dc_s) {
				$dc_select = $dc_select.'<option value="'.$dc.'" selected>'.$dc.'</option>';
			} else {
				$dc_select = $dc_select.'<option value="'.$dc.'">'.$dc.'</option>';	
			}			
    	}
    	$result->free();
    	$dc_select = $dc_select.'</select>';
    }

    //Get first crash type
    $sql = "select distinct accidents.FIRST_CRASH_TYPE from accidents Order By 1";
    $result = $conn->query($sql);
    $fct_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$fct_select = '<select id="fct" name="fct" class="form-control"><option value="">-select crash type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$fct = $row["FIRST_CRASH_TYPE"];
			if ($fct == $fct_s) {
				$fct_select = $fct_select.'<option value="'.$fct.'" selected>'.$fct.'</option>';
			} else {
				$fct_select = $fct_select.'<option value="'.$fct.'">'.$fct.'</option>';	
			}				
    	}
    	$result->free();
    	$fct_select = $fct_select.'</select>';
    }

    //Get traffic way type
    $sql = "select distinct accidents.TRAFFICWAY_TYPE from accidents Order By 1";
    $result = $conn->query($sql);
    $twt_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$twt_select = '<select id="twt" name="twt" class="form-control"><option value="">-select way type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$twt = $row["TRAFFICWAY_TYPE"];
			if ($twt == $twt_s) {
				$twt_select = $twt_select.'<option value="'.$twt.'" selected>'.$twt.'</option>';
			} else {
				$twt_select = $twt_select.'<option value="'.$twt.'">'.$twt.'</option>';
			}				
    	}
    	$result->free();
    	$twt_select = $twt_select.'</select>';
    }

    //Get alignment
    $sql = "select distinct accidents.ALIGNMENT from accidents Order By 1";
    $result = $conn->query($sql);
    $alm_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$alm_select = '<select id="alignment" name="alignment" class="form-control"><option value="">-select alignment-</option>';
    	while($row = $result->fetch_assoc()) {
    		$alignment = $row["ALIGNMENT"];    		
			if ($alignment == $alignment_s) {
				$alm_select = $alm_select.'<option value="'.$alignment.'" selected>'.$alignment.'</option>';
			} else {
				$alm_select = $alm_select.'<option value="'.$alignment.'">'.$alignment.'</option>';
			}				
    	}
    	$result->free();
    	$alm_select = $alm_select.'</select>';
    }
	
    //Get roadway surface condition
    $sql = "select distinct accidents.ROADWAY_SURFACE_COND from accidents Order By 1";
    $result = $conn->query($sql);
    $rsc_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$rsc_select = '<select id="rsc" name="rsc" class="form-control"><option value="">-select surface condition-</option>';
    	while($row = $result->fetch_assoc()) {
    		$rsc = $row["ROADWAY_SURFACE_COND"];
			if ($rsc == $rsc_s) {
				$rsc_select = $rsc_select.'<option value="'.$rsc.'" selected>'.$rsc.'</option>';
			} else {
				$rsc_select = $rsc_select.'<option value="'.$rsc.'">'.$rsc.'</option>';
			}			
    	}
    	$result->free();
    	$rsc_select = $rsc_select.'</select>';
    }

    //Get crash type
    $sql = "select distinct accidents.CRASH_TYPE from accidents Order By 1";
    $result = $conn->query($sql);
    $ct_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$ct_select = '<select id="crashtype" name="crashtype" class="form-control"><option value="">-select crash type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$crashtype = $row["CRASH_TYPE"];
			if ($crashtype == $crashtype_s) {
				$ct_select = $ct_select.'<option value="'.$crashtype.'" selected>'.$crashtype.'</option>';
			} else {
				$ct_select = $ct_select.'<option value="'.$crashtype.'">'.$crashtype.'</option>';
			}			
    	}
    	$result->free();
    	$ct_select = $ct_select.'</select>';
    }	

    //Get injury type
    $sql = "select distinct accidents.MOST_SEVERE_INJURY from accidents Order By 1";
    $result = $conn->query($sql);
    $msi_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$msi_select = '<select id="msi" name="msi" class="form-control"><option value="">-select injury type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$msi = $row["MOST_SEVERE_INJURY"];
			if ($msi == $msi_s) {
				$msi_select = $msi_select.'<option value="'.$msi.'" selected>'.$msi.'</option>';
			} else {
				$msi_select = $msi_select.'<option value="'.$msi.'">'.$msi.'</option>';
			}			
    	}
    	$result->free();
    	$msi_select = $msi_select.'</select>';
    }

    //Get location
    $sql = "SELECT location_id, community_area, community_side FROM location Order By 2";
    $result = $conn->query($sql);
    $location_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	$location_select = '<select id="location" name="location" class="form-control"><option value="">-select location-</option>';
    	while($row = $result->fetch_assoc()) {
    		$lid = $row["location_id"];
    		$area = $row["community_area"];
    		$community = $row["community_side"];
			if ($lid == $lid_s) {
				$location_select = $location_select.'<option value="'.$lid.'" selected>'.$area.'    -    '.$community.'</option>';
			} else {
				$location_select = $location_select.'<option value="'.$lid.'">'.$area.'    -    '.$community.'</option>';
			}			
    	}
    	$result->free();
    	$location_select = $location_select.'</select>';
    }	

    // Get weather condition
    $sql = "SELECT wid, weather FROM weather Order By 1";
    $result = $conn->query($sql);
    $weather_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	$weather_select = '<select id="weather" name="weather" class="form-control"><option value="">-select weather-</option>';
    	while($row = $result->fetch_assoc()) {
    		$wid = $row["wid"];
    		$weather = $row["weather"];
			if ($wid == $wid_s) {
				$weather_select = $weather_select.'<option value="'.$wid.'" selected>'.$weather.'</option>';
			} else {
				$weather_select = $weather_select.'<option value="'.$wid.'">'.$weather.'</option>';
			}			
    	}
    	$result->free();
    	$weather_select = $weather_select.'</select>';
    }

    // Get lighting condition
    $sql = "SELECT lid, lighting FROM light_condition Order By 1";
    $result = $conn->query($sql);
    $lighting_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	$lighting_select = '<select id="lighting" name="lighting" class="form-control"><option value="">-select lighting condition-</option>';
    	while($row = $result->fetch_assoc()) {
    		$lgid = $row["lid"];
    		$lighting = $row["lighting"];
    		
			if ($lgid == $lgid_s) {
				$lighting_select = $lighting_select.'<option value="'.$lgid.'" selected>'.$lighting.'</option>';
			} else {
				$lighting_select = $lighting_select.'<option value="'.$lgid.'">'.$lighting.'</option>';
			}			
    	}
    	$result->free();
    	$lighting_select = $lighting_select.'</select>';
    }
	
    // Get contributory cause
    $sql = "SELECT cid, cause_desc FROM contributory_cause Order By 2";
    $result = $conn->query($sql);
    $cause_select = "";

    if ($result->num_rows > 0) {
    	// output data of each row
    	$cause_select1 = '<select id="primcause" name="primcause" class="form-control"><option value="">-select primary cause-</option>';
    	$cause_select2 = '<select id="seccause" name="seccause" class="form-control"><option value="">-select secondary cause-</option>';
    	while($row = $result->fetch_assoc()) {
    		$cid = $row["cid"];
    		$causedesc = $row["cause_desc"];
			if ($cid == $primcause_s) {
				$cause_select1 = $cause_select1.'<option value="'.$cid.'" selected>'.$causedesc.'</option>';
			} else {
				$cause_select1 = $cause_select1.'<option value="'.$cid.'">'.$causedesc.'</option>';
			}
			if ($cid == $seccause_s) {
				$cause_select2 = $cause_select2.'<option value="'.$cid.'" selected>'.$causedesc.'</option>';
			} else {
				$cause_select2 = $cause_select2.'<option value="'.$cid.'">'.$causedesc.'</option>';
			}			
    	}
    	$result->free();
    	$cause_select1 = $cause_select1.'</select>';
    	$cause_select2 = $cause_select2.'</select>';
    }

    $conn->close();	
	
    //Street Direction
	$stdir_select = '<select id="stdir" name="stdir" class="form-control"><option value="" disabled selected style="display:none;">Please Choose</option>';
	for ($i = 0; $i < count($stdir_array); $i++) {
		$stdir = $stdir_array[$i];
		if ($stdir == $stdir_s) {
			$stdir_select = $stdir_select.'<option value="'.$stdir.'" selected>'.$stdir.'</option>';
		} else {
			$stdir_select = $stdir_select.'<option value="'.$stdir.'">'.$stdir.'</option>';
		}
	}
	$stdir_select = $stdir_select.'</select>';		
	
    //Posted Speed Limit
	$psl_select = '<select id="psl" name="psl" class="form-control"><option value="">-select speed limit-</option>';
	for ($i = 0; $i < count($psl_array); $i++) {
		$psl = $psl_array[$i];
		if ($psl == $psl_s) {
			$psl_select = $psl_select.'<option value="'.$psl.'" selected>'.$psl.' mph</option>';
		} else {
			$psl_select = $psl_select.'<option value="'.$psl.'">'.$psl.' mph</option>';
		}
	}
	$psl_select = $psl_select.'</select>';	

    //Hit And Run
	$hnr_select = '<select id="hnr" name="hnr" class="form-control"><option value="">-select-</option>';
	for ($i = 0; $i < count($yn_array); $i++) {
		$hnr = $yn_array[$i];
		if ($hnr == $hnr_s) {
			$hnr_select = $hnr_select.'<option value="'.$hnr.'" selected>'.$hnr.'</option>';
		} else {
			$hnr_select = $hnr_select.'<option value="'.$hnr.'">'.$hnr.'</option>';
		}
	}
	$hnr_select = $hnr_select.'</select>';

    // Damage
    $damage = '<select id="damage" name="damage" class="form-control"><option value="" selected>-select damage-</option>';
    $damage = $damage.'<option value="$500 OR LESS">$500 OR LESS</option>'.'<option value="$501 - $1,500">$501 - $1,500</option>'.'<option value="OVER $1,500">OVER $1,500</option>';
    $damage = $damage.'</select>';
	
    // Road Defect
	$rddef_select = '<select class="form-control" id="rddef" name="rddef">';
	for ($i = 0; $i < count($rddef_array); $i++) {
		$rddef = $rddef_array[$i];
		if ($rddef == $rddef_s) {
			$rddef_select = $rddef_select.'<option value="'.$rddef.'" selected>'.$rddef.'</option>';
		} else {
			$rddef_select = $rddef_select.'<option value="'.$rddef.'">'.$rddef.'</option>';
		}
	}
	$rddef_select = $rddef_select.'</select>';

    if(!empty($_GET['error'])){
    	echo '<p align="center">'.$_GET['error'].'</p>';
    }
    if(!empty($_GET['newrdno'])){
    	echo '<p align="center">Record No '.$_GET['newrdno'].' created successfully!</p>';
    }
	
?>

    <!-- main -->
    <div class="container">
      <h1>Update Traffic Report</h1>
      <h5>Contribute to Safer Roads in Chicago
	  <div align="right"><a href="user_profile.php"><b>Return to Profile</b></a></div></h5>
			
	  <form action="update_accident3.php" method="post">

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
	                  <input type="text" id="stno" name="stno"class="form-control"  value="<?php echo $stno_s; ?>">
	                </div>
	                <div class="col-md-6">
	                  <label> Street Name </label>
	                  <input type="text" id="stname" name="stname" class="form-control" value="<?php echo $stname_s; ?>">
	                </div>
	                <div class="col-md-2">
	                  <label> Street Direction </label>
					  <?php echo $stdir_select; ?>
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
										<?php echo $psl_select; ?>
									</div>
								</div>
								<div class="row form-group">
									<div class="col-md-6">
										<label> Crash Datetime </label>
										<input type="datetime-local" class="form-control" name="crashDate" value="<?php echo $crashdate_s; ?>">
									</div>
									<div class="col-md-6">
										<label> Police Notice Datetime </label>
										<input type="datetime-local" class="form-control" name="policenotified" value="<?php echo $policenotified_s; ?>">
									</div>
	              </div>

	              <label> Traffic Control Device </label>
	              <?php echo $tcd_select; ?>
	              <br>
	              <label> Device Conditions </label>
	              <?php echo $dc_select; ?>
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
	                  <?php echo $twt_select; ?>
	                </div>
	                <div class="col-md-4">
	                  <label> Lane Count </label>
	                  <input type="number" class="form-control" name="lanecnt" value="<?php echo $lanecnt_s; ?>">
	                </div>
	                <div class="col-md-4">
	                  <label> Alignment </label>
	                  <?php echo $alm_select; ?>
	                </div>
	                <div class="col-md-6">
	                  <label> Roadway Surface Condition </label>
	                  <?php echo $rsc_select?>
	                  </select>
	                </div>
	                <div class="col-md-6">
	                  <label> Road Defect </label>
					  <?php echo $rddef_select?>
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
	                  <?php echo $ct_select; ?>
	                </div>
	                <div class="col-md-6">
	                  <label> Damage </label>
	                  <?php echo $damage; ?>
	                </div>
	                <div class="col-md-4">
	                  <label>  Most Severe Injury </label>
	                  <?php echo $msi_select; ?>
	                </div>
	                <div class="col-md-4">
	                  <label> Fatal Injury </label>
	                  <input type="text" id="injuriesfatal" name="injuriesfatal" class="form-control" value="<?php echo $injuriesfatal_s; ?>">
	                </div>
	                <div class="col-md-4">
	                  <label> Total Injury </label>
	                  <input type="text" id="totalinjuries" name="totalinjuries" class="form-control" value="<?php echo $totalinjuries_s; ?>">
	                </div>
	                <div class="col-md-6">
	                  <label> First Crash Type </label>
	                  <?php echo $fct_select; ?>
	                </div>
	                <div class="col-md-6">
	                  <label> Hit and Run </label>
	                  <?php echo $hnr_select; ?>
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
					<input type="submit" class="button medium" value="Update Accident">
					<input type="reset" class="button medium" value="Reset">
				</div>
			</form>
    </div>
  </br>
    <!-- Footer -->
		<?php include "footer.php"; ?>
  </body>

  </body>
</html>