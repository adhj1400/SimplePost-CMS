<?php

/**
 * MySQL database implementation to use for Connection interface.
 *
 * @author Adam Hjernquist
 */
class MySQLConnection implements Connection
{
	private $mysqli;	// The db connection
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;

    /**
     * Constructor sets default database variables.
     *
     * @param db_host
     * @param db_user
     * @param db_pass
     * @param db_name
     */
	function __construct($db_host, $db_user, $db_pass, $db_name)
	{
		// Setup database information
		$this->db_host = $db_host;
		$this->db_user = $db_user;
		$this->db_pass = $db_pass;
		$this->db_name = $db_name;

		// Connect to database
		$this->mysqli = new mysqli($this->db_host, $this->db_user, 
                                   $this->db_pass);

        // If host/DNS connection failed
        if ($this->mysqli->connect_error)
        {
            throw new ErrorException("Could not connect to DNS '$db_host'. Check host name, database username and database user password. Error message: " . $this->mysqli->connect_error);
        }

		// Select the database
        $this->mysqli->select_db($this->db_name);

        // Check if user defined database exists, else show
        // error message
        $result = $this->mysqli->query("SELECT DATABASE()");
        $row = $result->fetch_row();

        if (!$result)
        {
            throw new ErrorException("Database '$db_name' doesn't exist.<br>
                Go into your database management system and create one.");
        }
        else if($row[0] != $this->db_name)
        {
            throw new ErrorException("Database '$db_name' not selected. Current 
                database is $row[0].");
        }
	}

    /**
     * Escape special characters. Useful to use on user INSERT queries 
     * before executing to avoid errors.
     *
     * @param query    The sql query string
     *
     * @return The processed query
     */
    public function escapeString($query)
    {
        return $this->mysqli->real_escape_string($query);
    }

    /**
     * Check if database exists.
     *
     * @return The bool truth value
     */
	private function exists()
	{
		if ($result = $this->mysqli->query("SELECT DATABASE()")) 
		{
		    $row = $result->fetch_row();

            // If the row is empty, then the database doesn't exist.
		    if($row[0] == "")
			{
				return false;
			}

		    $result->close();
		}

		return true;
	}

	/**
	 * Perform query on the database.
     *
     * SELECT returns all columns normally. For INSERT, UPDATE, DELETE, 
     * etc, returns TRUE on success or FALSE on error.
     *
     * @param query
     *
     * @return A processed result array
	 */
	public function query($query) 
	{
        // Array to return
        $result = $this->mysqli->query($query);
        $return['success'] = true;

        if($result === false)
        {
            $return['success'] = false;
            $return['error'] = $this->mysqli->error;
            
            return $return;
        }
        if ($result === TRUE)
        {
            return $return;
        }

        $return['affected_rows'] = $this->mysqli->affected_rows;
        $return['insert_id'] = $this->mysqli->insert_id;

        if(0 == $this->mysqli->insert_id)
        {
            $return['num_rows'] = $result->num_rows;
            $return['rows'] = array();

            // Fetch array
            while ($row = $result->fetch_array())
            {
                $return['rows'][] = $row;
            }

            // Close the connection
            $result->close();
        }

        return $return;
    }

    /**
     * Get DBMS version.
     *
     * @return The current MySQL framework version.
     */
    public function getVersion()
    {
    	return $this->mysqli->server_version;
    }

	/**
     * Try closing the connection on termination.
     *
     */
    public function __destruct() 
    {
    	if($this->mysqli != null)
    	{
        	$this->mysqli->close()
           		OR die("There was a problem disconnecting from the database.");
    	}
    }

    /**
     * Return a single entry.
     *
     * @param query
     *
     * @return The entry
     */
    public function getSingleEntry($query)
    {
        $result = $this->query($query);

        if ($result['success'])
        {
            return $result['rows'][0][0];
        }

        return 1;
    }
    
}

?>