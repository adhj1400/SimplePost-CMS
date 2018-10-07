<?php
include("sp-config.php");

/* Send non-authorized requests to login page */
if (empty($_SESSION["login_user"])) 
{
	header("location:login.php");
	exit();
}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Admin Tools</title>
		<link rel="stylesheet" href="css/style_admin.css" type="text/css">
		<link rel="stylesheet" href="css/style_warning.css" type="text/css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="js/edit-tools.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>

	<body>
		<?php include("sp-alert_message.php"); ?>