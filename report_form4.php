<?php
$GLOBALS['CURRENT_PAGE'] = "Report Accidents";
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
    <title>Online Traffic Report</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/skel.min.js"></script>
		<script src="js/skel-layers.min.js"></script>
    <script src="js/init.js"></script>
		
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
		<link rel="stylesheet" type="text/css" href="css/autocomplete.css" />

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

    // Define variables and initialize with empty values
    $stno = $stname = $stdir = $rddef = $tcd = $crashDate = $totalinjuries = $dc = $fct = $twt = $lanecnt = $alignment = $rsc = $crashtype = $msi = $location = $weather = $lighting = $primcause = $seccause = $policenotified = $psl = $hnr = $damage = $injuriesfatal = "";

		//Get street name
		$sql = "select distinct accidents.STREET_NAME from accidents Order By 1";
		$result = $conn->query($sql);
		$street_list =""
		if ($result->num_rows > 0) {
    	// generate array for autocomplete
    	$street_list = '[';
    	while($row = $result->fetch_assoc()) {
    		$street = $row["STREET_NAME"];
    		$street_list = $street_list.'"'.$street.'"'.',';
    	}
    	$result->free();
    	$street_list = substr($street_list,0,-1).']';
    }

    //Get traffic control device
    $sql = "select distinct accidents.TRAFFIC_CONTROL_DEVICE from accidents Order By 1";
    $result = $conn->query($sql);
    $tcd_select = "";
    if ($result->num_rows > 0) {
    	// output data of each row
    	$tcd_select = '<select id="tcd" name="tcd" class="form-control"><option value="" disabled selected style=\'display:none;\'>Pleaser Choose</option>';
    	while($row = $result->fetch_assoc()) {
    		$tcd = $row["TRAFFIC_CONTROL_DEVICE"];
    		$tcd_select = $tcd_select.'<option value="'.$tcd.'">'.$tcd.'</option>';
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
    	$dc_select = '<select id="dc" name="dc" class="form-control"><option value="" disabled selected style=\'display:none;\'>Pleaser Choose</option>';
    	while($row = $result->fetch_assoc()) {
    		$dc = $row["DEVICE_CONDITION"];
    		$dc_select = $dc_select.'<option value="'.$dc.'">'.$dc.'</option>';
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
    	$fct_select = '<select id="fct" name="fct" class="form-control"><option value="" selected>-select crash type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$fct = $row["FIRST_CRASH_TYPE"];
    		$fct_select = $fct_select.'<option value="'.$fct.'">'.$fct.'</option>';
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
    	$twt_select = '<select id="twt" name="twt" class="form-control"><option value="" selected>-select way type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$twt = $row["TRAFFICWAY_TYPE"];
    		$twt_select = $twt_select.'<option value="'.$twt.'">'.$twt.'</option>';
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
    	$alm_select = '<select id="alignment" name="alignment" class="form-control"><option value="" selected>-select alignment-</option>';
    	while($row = $result->fetch_assoc()) {
    		$alignment = $row["ALIGNMENT"];
    		$alm_select = $alm_select.'<option value="'.$alignment.'">'.$alignment.'</option>';
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
    	$rsc_select = '<select id="rsc" name="rsc" class="form-control"><option value="" selected>-select surface condition-</option>';
    	while($row = $result->fetch_assoc()) {
    		$rsc = $row["ROADWAY_SURFACE_COND"];
    		$rsc_select = $rsc_select.'<option value="'.$rsc.'">'.$rsc.'</option>';
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
    	$ct_select = '<select id="crashtype" name="crashtype" class="form-control"><option value="" selected>-select crash type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$crashtype = $row["CRASH_TYPE"];
    		$ct_select = $ct_select.'<option value="'.$crashtype.'">'.$crashtype.'</option>';
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
    	$msi_select = '<select id="msi" name="msi" class="form-control"><option value="" selected>-select injury type-</option>';
    	while($row = $result->fetch_assoc()) {
    		$msi = $row["MOST_SEVERE_INJURY"];
    		$msi_select = $msi_select.'<option value="'.$msi.'">'.$msi.'</option>';
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
    	$location_select = '<select id="location" name="location" class="form-control"><option value="" selected>-select location-</option>';
    	while($row = $result->fetch_assoc()) {
    		$lid = $row["location_id"];
    		$area = $row["community_area"];
    		$community = $row["community_side"];
    		$location_select = $location_select.'<option value="'.$lid.'">'.$area.'    -    '.$community.'</option>';
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
    	$weather_select = '<select id="weather" name="weather" class="form-control"><option value="" selected>-select weather-</option>';
    	while($row = $result->fetch_assoc()) {
    		$wid = $row["wid"];
    		$weather = $row["weather"];
    		$weather_select = $weather_select.'<option value="'.$wid.'">'.$weather.'</option>';
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
    	$lighting_select = '<select id="lighting" name="lighting" class="form-control"><option value="" selected>-select lighting condition-</option>';
    	while($row = $result->fetch_assoc()) {
    		$lgid = $row["lid"];
    		$lighting = $row["lighting"];
    		$lighting_select = $lighting_select.'<option value="'.$lgid.'">'.$lighting.'</option>';
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
    	$cause_select1 = '<select id="primcause" name="primcause" class="form-control"><option value="" selected>-select primary cause-</option>';
    	$cause_select2 = '<select id="seccause" name="seccause" class="form-control"><option value="" selected>-select secondary cause-</option>';
    	while($row = $result->fetch_assoc()) {
    		$cid = $row["cid"];
    		$causedesc = $row["cause_desc"];
    		$cause_select1 = $cause_select1.'<option value="'.$cid.'">'.$causedesc.'</option>';
    		$cause_select2 = $cause_select2.'<option value="'.$cid.'">'.$causedesc.'</option>';
    	}
    	$result->free();
    	$cause_select1 = $cause_select1.'</select>';
    	$cause_select2 = $cause_select2.'</select>';
    }

    $conn->close();

    //Posted Speed Limit
    $psl_select = "";
    $psl_select = '<select id="psl" name="psl" class="form-control"><option value="" selected>-select speed limit-</option>';
    $psl_select = $psl_select.'<option value="5">5 mph</option>'.'<option value="10">10 mph</option>'.'<option value="15">15 mph</option>'.'<option value="20">20 mph</option>';
    $psl_select = $psl_select.'<option value="25">25 mph</option>'.'<option value="30">30 mph</option>'.'<option value="35">35 mph</option>';
    $psl_select = $psl_select.'<option value="40">40 mph</option>'.'<option value="45">45 mph</option>'.'<option value="50">50 mph</option>';
    $psl_select = $psl_select.'<option value="55">55 mph</option>'.'<option value="60">60 mph</option>'.'<option value="65">65 mph</option>';
    $psl_select = $psl_select.'<option value="70">70 mph</option>'.'<option value="75">75 mph</option>'.'<option value="80">80 mph</option>';
    $psl_select = $psl_select.'<option value="85">85 mph</option>'.'<option value="90">90 mph</option>'.'<option value="95">95 mph</option>';
    $psl_select = $psl_select.'</select>';

    //Hit And Run
    $hnr_select = "";
    $hnr_select = '<select id="hnr" name="hnr" class="form-control"><option value="" selected>-select-</option>';
    $hnr_select = $hnr_select.'<option value="Y">Yes</option>'.'<option value="N">No</option>';
    $hnr_select = $hnr_select.'</select>';

    // Damage
    $damage = '<select id="damage" name="damage" class="form-control"><option value="" selected>-select damage-</option>';
    $damage = $damage.'<option value="$500 OR LESS">$500 OR LESS</option>'.'<option value="$501 - $1,500">$501 - $1,500</option>'.'<option value="OVER $1,500">OVER $1,500</option>';
    $damage = $damage.'</select>';



    if(!empty($_GET['error'])){
    	echo '<p align="center">'.$_GET['error'].'</p>';
    }
    if(!empty($_GET['newrdno'])){
    	echo '<p align="center">Record No '.$_GET['newrdno'].' created successfully!</p>';
    }
    ?>
		<script>
			var streets = <?php echo $street_list ?>;
			autocomplete(document.getElementById("stname"), streets);
		</script>
    <!-- main -->
    <div class="container">
      <h1>Online Traffic Report</h1>
      <h5>Contribute to Safer Roads in Chicago</h5>
      <hr>

			<form autocomplete="off" action="insert_accident3.php" method="post">

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
	                  <input type="text" id="rdno" name="rdno" class="form-control" value="" disabled>
	                </div>
	                <div class="col-md-2">
	                  <label> Street No. </label>
										<input id="stno" type="text" class="form-control" name="stno" value="">
	                </div>
	                <div class="col-md-6">
	                  <label> Street Name </label>
						
	                  	<input type="text" id="stname" name="stname" class="form-control" value="">
	
	                </div>
	                <div class="col-md-2">
	                  <label> Street Direction </label>
										<select id="stdir" name="stdir" class="form-control">
	                    <option value="" disabled selected style='display:none;'>Pleaser Choose</option>
	                    <option value="N">N</option>
	                    <option value="W">W</option>
	                    <option value="E">E</option>
	                    <option value="S">S</option>
	                  </select>
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
										<input type="datetime-local" class="form-control" name="crashDate" value="">
									</div>
									<div class="col-md-6">
										<label> Police Notice Datetime </label>
										<input type="datetime-local" class="form-control" name="policenotified" value="">
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
	                  <input type="number" class="form-control" name="lanecnt" value="">
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
	                  <select class="form-control" name="rddef">
	                    <option value="" disabled selected style='display:none;'>Pleaser Choose</option>
	                    <option value="NO DEFECTS">NO DEFECTS</option>
	                    <option value="WORN SURFACE">WORN SURFACE</option>
	                    <option value="DEBRIS ON ROADWAY">DEBRIS ON ROADWAY</option>
	                    <option value="RUT, HOLES">RUT, HOLES</option>
	                    <option value="UNKNOWN">UNKNOWN</option>
	                  </select>
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
	                  <input type="text" id="injuriesfatal" name="injuriesfatal" class="form-control" value="">
	                </div>
	                <div class="col-md-4">
	                  <label> Total Injury </label>
	                  <input type="text" id="totalinjuries" name="totalinjuries" class="form-control" value="">
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
				<div class="form-group">
					<input type="submit" class="button medium" value="Report Accident">
					<input type="reset" class="button medium" value="Reset">
				</div>
			</form>
    </div>
  </br>
    <!-- Footer -->
		<?php include "footer.php"; ?>
  </body>

</html>
