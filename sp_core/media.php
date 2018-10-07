
<?php

include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php'); 

// If we are uploading an image, show upload box
if(isset($_POST['upload-img']))
{
	include("includes/sp-upload-box.php");
}

// If we are to delete a specific image
if(isset($_POST["delete"]))
{
	$sql = "DELETE FROM images WHERE image_id ='" . $_POST["delete"] . "';";
	$sql_2 = "SELECT path_filename FROM images WHERE image_id ='". $_POST["delete"] ."';";

	// Get filename and path of media to delete
	$result_2 = $database->query($sql_2);

	// Delete media from database
	$result = $database->query($sql);

	// Delete media file from server
	try
	{
		unlink($result_2['rows'][0]['path_filename']);
	}
	catch(Exception $e)
	{
		// File could not be deleted. Refresh and display message.
		$_SESSION["notice"] = "No file was deleted from the server. File deleted from database.";
		header("Refresh:0");

	}
}

?>

<div class="container">
	<div class="row">
		<form action="media.php" method="post">
			<button class="button" type="submit" name="upload-img">Add image</button>
		</form>
	</div>

	<div class="row">
		<div class="wide-media">
			<div class="inner-box">
				<div class="title-box">
					Images (<?php 
						$result = $database->query("SELECT * FROM images;");
						echo $result['affected_rows'];?>)
				</div>
		
				<div id="content-grid">
					<!-- Print table -->
					<?php

					$imageHandler = new ImageHandler();
					$imageHandler->displayGrid($database, true, false, "big", 0);
					
			        ?>
				</div>	
			</div>
		</div>
	</div>
</div>

<?php include('includes/sp-footer.php'); ?>
