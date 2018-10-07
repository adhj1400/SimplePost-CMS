<?php 
include($_SERVER['DOCUMENT_ROOT']."/config.php"); 

if (!isset($_SESSION["new_user"]) && !isset($_POST["AddUser"]))
{
	exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Create new user</title>
		<link rel="stylesheet" href="../css/style_login.css" type="text/css">
		<link rel="stylesheet" href="css/style_warning.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<?php include("sp-alert_message.php"); ?>

		<form id="login-form" action="sp-create_user_script.php" method="post">
		  	<div class="container">

		  		<h2><center><b>Create new user</b></center></h2>
		  		<br><br>

		  		<label for="fullname"><b>Please enter your full name.</b> This will be your author name and the name readers and other users will know you by.</label>
		    	<input type="text" placeholder="Enter Fullname" name="fullname" required>
		    	<br><br><br><br><br>

		    	<h2><center>Login credentials</center></h2>
		    	<label for="username"><b>Username</b></label>
		    	<input type="text" placeholder="Enter Username" name="username" required>

		    	<label for="password"><b>Password</b></label>
		    	<input type="password" placeholder="Enter Password" name="password" required>
		        
		    	<button type="submit">Login</button>
		    	<?php

		    	if (isset($_SESSION["username_taken"]))
		    	{
		    		
		    		echo "<p style='color:red;'>". $_SESSION["username_taken"] ."</p>";

		    		unset($_SESSION["username_taken"]);
		    	}

		    	if (isset($_SESSION["fakeload"]))
		    	{
			    	echo "<p style='font-family:monospace;'>";
			    	echo "Initializing SimplePost sql...    ";
			    	ob_end_flush();
					flush();
					usleep(500000);
					echo "<b>Done!</b></p>";

			    	echo "<p style='font-family:monospace;'>";
			    	echo "Creating database tables...    ";
					flush();
					usleep(2000000);
					echo "<b>Done!</b></p>";

					echo "<p style='font-family:monospace;'>";
			    	echo "Setting up relation constraints...    ";
					flush();
					usleep(3000000);
					echo "<b>Done!</b></p>";

					echo "<p style='font-family:monospace;'>";
			    	echo "Preparing for new user creation...    ";
					flush();
					usleep(1000000);
					echo "<b>Done!</b></p>";

					echo "<p style='font-family:monospace;'>";
			    	echo "Waiting for user input...    ";
			    	echo "</p>";

			    	unset($_SESSION["fakeload"]);
			    }

		    	?>
		  	</div>
		</form>
	</body>
</html>
