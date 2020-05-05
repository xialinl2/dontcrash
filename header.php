<?php
    $loginlink = "";
    $headertext = !isset($GLOBALS['CURRENT_PAGE']) ? "Accident Analysis" : $GLOBALS['CURRENT_PAGE'];
    
    if(!isset($_SESSION))
    { 
    	session_start(); 
    } 
    
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
    {
    	$loginlink = '<li><a href="register.php" class="button special">Sign Up</a></li>';
    }
    else
    {
        require 'connection.php';
        $sql_header = "SELECT * FROM notification".
            " WHERE USERNAME = '".$_SESSION["username"]."'".
            " AND STATUS = 0";
        $result = $conn->query($sql_header);
        $rows = $result->num_rows;
        if ($rows == 0)
        {
            $badge_id = 'transparent';
        }
        else
        {
            $badge_id = 'count';
        }

    	$loginlink = '<li>'.$_SESSION["username"].'&nbsp'.
    	    '<a href="accident_alerts.php">
    	        <i class="fas fa-envelope"></i></a>
    	    <span class="badge" id="'.$badge_id.'">'.$rows.'</span>'.
    	    '<a href="logout.php" class="button special">Logout</a>
            </li>';
    }
?>



<script src="https://kit.fontawesome.com/d32b4687c4.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<style>
    #count {
        border-radius:50%;
        background-color:red;
        position:relative;
        top:-10px;
        left:-10px;
    }
    #transparent {
        opacity: 0;
        position:relative;
        top:-10px;
        left:-10px;
    }
</style>

<header id="header">
	<h1><?php echo $headertext; ?></h1>
	<nav id="nav">
		<ul>
			<li><a href="index.php">Home</a></li>
			<li><a href="accidents_search.php">Accident Search</a></li>
			<li><a href="vehicles.php">Vehicles</a></li>
			<li><a href="people.php">People</a></li>
			<li><a href="user_profile.php">User Profile</a></li>
			<?php echo $loginlink; ?>
		</ul>
	</nav>
</header>