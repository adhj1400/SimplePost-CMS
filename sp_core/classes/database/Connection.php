<?php

/**
 * Interface for connecting to the main SimplePost database.
 *
 * @author Adam Hjernquist
 */
interface Connection
{
	public function query($query);

	public function getVersion();
	
	public function getSingleEntry($query);

	public function escapeString($string);
}

?>