<?php
/**
 * Bundles database tables into readable arrays.
 *
 * @author Adam Hjernquist
 */
class DBTableArchiver
{
	private $db;

	/**
	 * Constructor to remember the database instance
	 *
	 * @param db
	 */
	function __construct(&$db)
	{
		$this->db = $db;
	}


	/**
	 * Get a single post from the database.
	 *
	 * @param post_id 	The primary key
	 *
	 * @return Detailed readable information about this post
	 */
	function getSinglePost($post_id)
	{
		$sqlPost = "SELECT * FROM posts 
					WHERE post_id=$post_id;";

		$result = $this->db->query($sqlPost);
	    
	    // Check if query was successful
	    if (!$result['success'])
	    {
	    	echo $result['error'];
	    	return;
	    }

    	return $this->postAssemble($result["rows"][0]);
	}

	/**
	 * Returns all table entries of Post.
	 * 
	 * @param offset_start 	Offset start to fetch
	 * @param offset_end 	Offset end to fetch
	 * @param sort_by 		Sort by specific type
	 * 
	 * @return 2D array containing the post entries
	 */
	function getPostArray($offset_start, $offset_end, $sort_by)
	{
		$postArray = array();

		$sqlPost = "SELECT * FROM posts 
					WHERE status=1 ORDER BY $sort_by 
					DESC LIMIT $offset_start, $offset_end";

		$result = $this->db->query($sqlPost);
	    
	    // Return if query was unsuccessful
	    if (!$result['success'])
	    {
	    	echo $result['error'];
	    	return;
	    }

	    // Fill array with post information
        foreach($result['rows'] as $row)
        {
        	array_push($postArray, $this->postAssemble($row));
        }

        // Return entire array of post entries
        return $postArray;
	}

	/**
	 * Re-package acquired database array into a readable array. 
	 *
	 * @param row 	The database row entry
	 *
	 * @return The packaged array
	 */
	private function postAssemble($row)
	{
		// Get username from foreign key constraint
    	$user_fk = $row['users_fk'];
    	$sqlUser = "SELECT username FROM users 
					WHERE user_id=$user_fk";
		$useralias = $this->db->getSingleEntry($sqlUser);

		// Set post info
		$postEntry = array();
		$postEntry["post_id"] = $row["post_id"];
    	$postEntry["titel"] = $row["titel"];
    	$postEntry["image"] = "";
    	$postEntry["text"] = $row["text"];
    	$postEntry["status"] = $row["status"];
    	$postEntry["author"] = $useralias;
    	$postEntry["date"] = $row["date"];
    	$postEntry["edit_date"] = $row["edit_date"];

    	// If post preview image is set
    	if (json_encode($row["previewimage"]) == "")
    	{
    		$postEntry["image"] = $row["previewimage"];
    	}

    	// Return this post entry
    	return $postEntry;
	}

}

?>