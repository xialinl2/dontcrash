<?php
$GLOBALS['CURRENT_PAGE'] = "User Registration";

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = $firstname = $lastname = $email = $rcvalert = "";
$username_err = $password_err = $confirm_password_err = $firstname_err = $lastname_err = $email_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
     // Validate first name
    if(empty(trim($_POST["firstname"]))){
        $firstname_err = "Please enter a first name.";     
    } elseif(strlen(trim($_POST["firstname"])) < 2){
        $firstname_err = "First name must have atleast 2 characters.";
    } else{
        $firstname = trim($_POST["firstname"]);
    }
	
    // Validate last name
    if(empty(trim($_POST["lastname"]))){
        $lastname_err = "Please enter a last name.";     
    } elseif(strlen(trim($_POST["lastname"])) < 2){
        $lastname_err = "Last name must have atleast 2 characters.";
    } else{
        $lastname = trim($_POST["lastname"]);
    }

	// Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter an email address.";     
    } elseif(strlen(trim($_POST["password"])) < 5){
        $email_err = "Email must have atleast 5 characters.";
    } else{
        $email = trim($_POST["email"]);
    } 
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
	
	$rcvalert = trim($_POST["rcvalert"]);
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($firstname_err) && empty($lastname_err) && empty($email_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (first_name, last_name, email, username, password, rcv_alert) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_firstname, $param_lastname, $param_email, $param_username, $param_password, $param_rcvalert);
            
            // Set parameters
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_email = $email;			
            $param_username = $username;
			$param_rcvalert = $rcvalert;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
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
		<title>Registration Form</title>
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
		<p align="center">[ Already have an account? <b><a href="login.php">Login here</a></b> ]</p>
		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">
					<body>
						<div>
							<p>Please fill this form to create an account</p>
							<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
								<div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
									<label>First Name</label>
									<input type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
									<span class="help-block"><?php echo $firstname_err; ?></span>
								</div> 
								<div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
									<label>Last Name</label>
									<input type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
									<span class="help-block"><?php echo $lastname_err; ?></span>
								</div>
 								<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
									<label>Email</label>
									<input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
									<span class="help-block"><?php echo $email_err; ?></span>
								</div> 
								<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
									<label>Username</label>
									<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
									<span class="help-block"><?php echo $username_err; ?></span>
								</div>    
								<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
									<label>Password</label>
									<input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
									<span class="help-block"><?php echo $password_err; ?></span>
								</div>
								<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
									<label>Confirm Password</label>
									<input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
									<span class="help-block"><?php echo $confirm_password_err; ?></span>
								</div>
								<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
									<label>Receive Alert</label>
									<select id="rcvalert"  name="rcvalert" class="form-control" value="<?php echo $rcvalert; ?>">
									<option value="Y" selected>Yes</option>
									<option value="N">No</option>
									</select>
								</div>	
								<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
									<p></p>
								</div>								
								<div class="form-group">
									<input type="submit" class="btn btn-primary" value="Submit">
									<input type="reset" class="btn btn-default" value="Reset">
								</div>								
								<p>Already have an account? <a href="login.php">Login here</a>.</p>
							</form>
						</div>    
					</body>

				</div>
			</section>

		<!-- Footer -->
		<?php include "footer.php"; ?>

	</body>
</html>