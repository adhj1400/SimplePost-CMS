<?php

/**
 * Representing a database user.
 *
 * Notice: This class is (and should be) DBMS agnostic.
 *
 * @author Adam Hjernquist
 */
class DatabaseUser
{
	private $username;

	/**
	 * Constructor that sets the username.
	 *
	 * @param username
	 */
	function __construct($username)
	{
		$this->username = $username;
	}

	/**
	 * Checks username + password combination in the database.
	 *
	 * @param db 		Database instance reference
	 * @param password
	 *
	 * @return If match is found
	 */
	function login(&$db, $password)
	{
		// Username and password sent from form 
		$sql = "SELECT * FROM users
				WHERE username='$this->username' and password='$password'";

		// Pass query into database object
		$result = $db->query($sql);

		// Return if match are found
		return ($result['num_rows'] > 0);
	}
}

?>