<?php
/**
 * 	This is one messy file. Might need to rethink logic here... 
 		not very solid (at all). Needs to be fractioned into objects or something.
 */

include("../sp-config.php");

// On dialogue accept or failure; return to the edit page
header("Location: ../edit.php?id=$update");

$update = "";
$image = "";

// If we reload the page
if (isset($_POST['update']) && $_POST['update'] !== "")
{
	$update = $_POST['update'];
	$_SESSION["update_id_backup"] = $update;
}

// If we are inserting an image
if(isset($_POST['insert']))
{
	if(isset($_POST["subject"]) && $_POST['subject'] !== '')
	{
		$_SESSION["subject_backup"] = $_POST["subject"];
	}

	if(isset($_POST["post"]) && $_POST['post'] !== '')
	{
		$_SESSION["post_backup"] = $_POST["post"];
	}

	if(isset($_POST["thumbnail"]) && $_POST["thumbnail"] !== '')
	{
		// Remove base64 info
		$pos = strpos($_POST["thumbnail"], ",");

		// set session
		$_SESSION["thumbnail_backup"] = substr($_POST["thumbnail"], $pos + 1);
	}

	$_SESSION["insert"] = "image";

	exit();
}

// if error are encountered and a file were trying to be uploaded
if ($_FILES["fileToUpload"]["error"] != 0 && 
	 $_FILES["fileToUpload"]["error"] != 4)
{

	if(filesize($_FILES["fileToUpload"]["tmp_name"]) > THUMBNAIL_MAX_SIZE ||
		$_FILES["fileToUpload"]["tmp_name"] == "")
   {
    	$_SESSION["notice"] = "Thumbnail is too big! Choose an image smaller than ".THUMBNAIL_MAX_SIZE." bytes.";

   }
   elseif(getimagesize($_FILES["fileToUpload"]["tmp_name"]) === false) 
   {
      $_SESSION["notice"] = "File isn't an image.";
        
   }
	
	// remember
	$_SESSION["update_id_backup"] = $update;
	$_SESSION["subject_backup"] = $_POST["subject"];
	$_SESSION["post_backup"] = $_POST["post"];

	exit();
}

// If thumbnail is set
if(isset($_POST["thumbnail"]) && $_POST["thumbnail"] !== '')
{
	// remembers to decode it back from base64
	$parsed = $_POST["thumbnail"];

	// parse
	$pos = strpos($parsed, ",");
	$parsed = substr($parsed, $pos + 1);


	// do it
	$_SESSION["thumbnail_backup"] = $parsed;
	$image = base64_decode($parsed);
	$image = $database->escapeString($image);
}
elseif ($_FILES["fileToUpload"]["error"] != 4) // Thumbnail change by user
{
	$image = addslashes(file_get_contents($_FILES['fileToUpload']['tmp_name']));
}

// Main logic
if(isset($_POST["subject"]) && $_POST['subject'] !== '')
{
	$_SESSION["subject_backup"] = $_POST["subject"];

	if(isset($_POST["post"]) && $_POST['post'] !== '')
	{
		$_SESSION["post_backup"] = $_POST["post"];

		$date = date('Y-m-d H:i:s');
		$sql = "SELECT user_id FROM users 
        		WHERE username ='" . $_SESSION['login_user'] ."';";
		$userid = $database->getSingleEntry($sql);
		$subject = $database->escapeString($_POST['subject']);
		$post = $database->escapeString($_POST['post']);

		// Check if we should update or insert
		if($update != "")
		{
			$action = $_POST["action"];
			$update = $_POST["update"]; // Set new update value

			if ($image != "")
			{
				// Update entry
				$sql = "UPDATE posts SET titel='$subject', text='$post', 
						edit_date='$date', status=$action, previewimage='$image' 
						WHERE post_id='$update';";
			}
			else
			{
				$sql = "UPDATE posts SET titel='$subject', text='$post', 
						edit_date='$date', status=$action, previewimage=''
						WHERE post_id='$update';";
			}
		}
		// We are creating a new post
		else 
		{
			if ($image != null)
			{
				// Insert new entry
				$sql = "INSERT INTO posts (date, edit_date, status, 
						previewimage, titel, text, users_fk)
						VALUES ('$date', '$date', ". $_POST['action'] . 
						", '$image', '$subject', '$post', '$userid');";
			}
			else
			{
				$sql = "INSERT INTO posts (date, edit_date, status, 
						titel, text, users_fk)
						VALUES ('$date', '$date', ". $_POST['action'] 
						. ", '$subject', '$post', '$userid');";
			}
		}

		// Run query
		$result = $database->query($sql);

		if ($result['success'])
		{
			// If successful
			header("Location: ../posts.php");

			if ($_POST["action"] == 0 && $update == '')
			{
				$_SESSION["notice"] = "Post saved but not published.";
			}
			elseif ($_POST["action"] == 1 && $update == '')
			{
				$_SESSION["notice"] = "Post published successfully!";
			}
			else
			{
				$_SESSION["notice"] = "Post updated!";
			}
		}
		else 
		{
			$error = $result["error"]; // cant be displayed if blob
			$error = str_replace(' ', '-', $error);
			$error = preg_replace('/[^A-Za-z0-9\-]/', '', $error);
			$error = str_replace('-', ' ', $error);
			$_SESSION["notice"] = "Database error! Entry could not be created in the database. $error";

			return;
		}

		// Clear session variables
		unset($_SESSION["post_backup"]);
		unset($_SESSION["subject_backup"]);
		unset($_SESSION["update_id_backup"]);

		return;
	}

	// Warning, missing post content
	$_SESSION["notice"] = "Post missing!";
	$_SESSION["update_id_backup"] = $update;
}
else
{
	if(isset($_POST["post"]) && $_POST['post'] !== '')
	{
		$_SESSION["post_backup"] = $_POST["post"];
	}

	// Warning missing subject
	$_SESSION["notice"] = "Subject missing!";
	$_SESSION["update_id_backup"] = $update;
}

?>