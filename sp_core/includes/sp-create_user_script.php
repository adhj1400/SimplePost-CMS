
<?php
include($_SERVER['DOCUMENT_ROOT']."/config.php");

// Create first user
$username = $_POST["username"];
$fullname = $_POST["fullname"];
$password = $_POST["password"];

// Check if username already exists
$sql = "SELECT * FROM users WHERE username='". $username ."'";
$result = $database->query($sql);
$count = $result['num_rows'];

if($count != 1)
{
	$result = $database->query("INSERT INTO users (username, alias, password) VALUES ('".$username."', '".$fullname."', '".$password."');");

	if ($result["success"] == true)
	{
		$_SESSION["notice"] = "Welcome " . $fullname . "! Please log in using your username and password.";

		unset($_SESSION["new_user"]);

		header("location: ../login.php");
	}
	else
	{
		$_SESSION["username_taken"] = "Something went wrong.";
		header("location: sp-create_user.php");
	}
}
else
{
	$_SESSION["username_taken"] = "Username not available. Please choose another one.";
	header("location: sp-create_user.php");
}

// if successfull



?>