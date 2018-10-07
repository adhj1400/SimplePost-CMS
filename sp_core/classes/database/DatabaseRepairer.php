<?php

/**
 * Class to check and restore the database.
 *
 * @author Adam Hjernquist
 */
class DatabaseRepairer
{
	private $tableArray; // The array to check agains

	function __construct($tableArray)
	{
		$this->tableArray = $tableArray;
	}

	/**
	 * Check if tables exist.
	 *
	 * @return if all tables exist or not
	 */
	function checkTables(&$db)
	{
		foreach($this->tableArray as $table)
		{
			$result = $db->query("SELECT 1 FROM " . $table . ";");

			// if false
			if (!$result["success"])
			{
				return false;
			}
		}
		
		return true;
	}

	/**
	 * 
	 *
	 * @param db 	The database instance
	 */
	function createTables(&$db)
	{
		// Temporary variable, used to store current query
		$filename = $_SERVER['DOCUMENT_ROOT']."/sp_core/resources/sp-core-resources/simplepost_db.sql";
		$templine = '';

		// Get the entire file
		$lines = file($filename);

		// Loop through each line in sql file
		foreach ($lines as $line)
		{
			// Skip comments
			if (substr($line, 0, 2) == '--' || $line == '')
			{
			    continue;
			}

			// Add this line to the current segment
			$templine .= $line;

			// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
			    $db->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
			    
			    $templine = '';
			}
		}

	}
}

?>