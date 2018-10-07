<?php
	/**
	 * Unset the login_user name. Password is not stored on the server 
	 * so this is all it takes.
	 */
   session_start();

   unset($_SESSION["login_user"]);
   
   echo "Logout successful!";
   header('Refresh: 1; URL = login.php');
?>