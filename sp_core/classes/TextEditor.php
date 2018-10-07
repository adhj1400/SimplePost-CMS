<?php

/**
 * TextEditor superclass. Extend this class to modify and add custom
 * implementations of the post text editor.
 *
 * @author Adam Hjernquist
 */
class TextEditor
{
	// Variables to store
	public $get_id 		= "";
	public $post_id 		= "";
	public $subject 		= "";
	public $post_content	= "";
	public $thumbnail 	= "";
	public $post_info 	= "";
	public $status 		= "Unpublished";
	public $publish_date	= "";
	public $edit_date 	= "";
	public $author 		= "";
	
	/**
	 * Constructor sets all variables from sessions and unsets them.
	 *
	 * @param DBTableArchiver
	 * @param get_id
	 */
	function __construct($DBTableArchiver, $get_id)
	{
		$this->get_id = $get_id;
		$this->post_id = $this->getAndUnset("update_id_backup");

		// Set and unset session variables
		$this->subject 		= $this->getAndUnset("subject_backup");
		$this->post_content = $this->getAndUnset("post_backup");
		$this->thumbnail 	= $this->getAndUnset("thumbnail_backup");

		// If we update a post
		if($this->get_id > 0 && $this->post_id == "") 
		{
			// Get info from db
			$postArray = $DBTableArchiver->getSinglePost($this->get_id);

			// Set variables
			$this->subject = $postArray["titel"];
			$this->post_content = $postArray["text"];
			$this->thumbnail = base64_encode($postArray["image"]);
			$this->post_id = $this->get_id;
		}

		// Get publish/edit information
		if ($this->post_id > 0)
		{
			try 
			{
				$this->post_info = $DBTableArchiver->getSinglePost(
					$this->post_id);

				if ($this->post_info["status"] == 1)
				{
			    	$this->status = "Published";
				}
			    
			    $this->publish_date = date("l M j Y G:i", strtotime($this->post_info["date"]));
			    $this->edit_date = date("l M j Y G:i", strtotime($this->post_info["edit_date"]));
			    $this->author = $this->post_info["author"];
			} 
			catch (Exception $e) 
			{
				//$_SESSION["notice"] = $e;
			}
		}

	}

	/**
	 * Returns the php session variable and unsets it.
	 *
	 * @param session 	The session to unset
	 *
	 * @return The sessions value
	 */
	function getAndUnset($session)
	{
		$value = "";

		// If value is set, set $value and unset session
		if(isset($_SESSION[$session]))
		{
			$value = $_SESSION[$session];
			unset($_SESSION[$session]);
		}

		return $value;
	}

	/**
	 * Sets the array of objects.
	 *
	 */
	function getVariables()
	{
		return array("post_id" => $this->post_id, 
					 	 "subject" => $this->subject, 
					 	 "post_content" => $this->post_content, 
					 	 "thumbnail" => $this->thumbnail, 
					 	 "post_info" => $this->post_info,
					 	 "status" => $this->status,
					 	 "publish_date" => $this->publish_date,
					 	 "edit_date" => $this->edit_date,
					 	 "author" => $this->author);
	}

	/**
	 * Print the status
	 *
	 */
	function printStatus()
	{ 
		?>
		<p><b>Status</b>: <?= $this->status; ?></p>

		<?php 
		if ($this->post_id > 0)
		{ ?>
			<p><?= "<b>$this->status</b>: $this->publish_date;" ?></p>
			<p><?= "<b>Last edited</b>: $this->edit_date;" ?></p>
		<?php 
		}
	}

}



?>