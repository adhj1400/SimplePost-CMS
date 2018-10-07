<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");

if (!empty($_SESSION["login_user"])) 
{
	header("location:index.php");
	exit();
}

if($_SERVER["REQUEST_METHOD"]=="POST") 
{
	$username = $_POST['username'];
	$user = new DatabaseUser($username);

	// Try logging in user
	if ($user->login($database, $_POST['password']))
	{
	 	$_SESSION["login_user"] = $username;
	 	$_SESSION["notice"] = "Welcome back ".$username."!";
	 
	 	header("location: index.php");
	}
	else
	{
		$_SESSION["notice"] = "Username or password is incorrect. Try again or contact an administrator.";
	}
}

// Create first user
$defaultUsername = "admin";
$defaultFullname = "John Doe";
$defaultPassword = "password";

?>


<!DOCTYPE html>
<html>
	<head>
		<title>Logga in</title>
		<link rel="stylesheet" href="css/style_login.css" type="text/css">
		<link rel="stylesheet" href="css/style_warning.css" type="text/css">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>

	<body>
		<?php include("includes/sp-alert_message.php"); ?>
		<form id="login-form" action="" method="post">

		  	<div class="imgcontainer">
		    	<img src="resources/sp-core-resources/defaultuser.png" alt="Avatar" class="avatar">
		  	</div>

		  	<h2><center><b><?= CMS_NAME; ?><br>Login</b></center></h2>

		  	<div class="container">
		    	<label for="username"><b>Username</b></label>
		    	<input type="text" placeholder="Enter Username" name="username" required>

		    	<label for="password"><b>Password</b></label>
		    	<input type="password" placeholder="Enter Password" name="password" required>
		        
		    	<button type="submit">Login</button>
		  	</div>
		</form>
	</body>
</html>
