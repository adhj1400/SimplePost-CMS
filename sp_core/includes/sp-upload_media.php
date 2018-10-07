<?php

include("../sp-config.php");

$target_dir = "../resources/images/";
$target_dir_local = "resources/images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$target_file_local = $target_dir_local . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if(isset($_POST["cancel"]))
{
	returnNow();
}

// Check if there are errors and a file were selected
if ($_FILES["fileToUpload"]["error"] != 0 && 
    $_FILES["fileToUpload"]["error"] != 4)
{
    
    // Check file size
    if (filesize($_FILES["fileToUpload"]["tmp_name"]) > IMAGE_MAX_FILESIZE_B ||
        $_FILES["fileToUpload"]["tmp_name"] == "") 
    {
        $_SESSION["notice"] = "Filesize too large.";
        returnNow();
    }
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"]) && $_FILES["fileToUpload"]["tmp_name"] != "") 
{
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

    if($check === false) 
    {
        $_SESSION["notice"] = "File isn't an image.";
        returnNow();
    }

}
else
{
	$_SESSION["notice"] = "File not uploaded. Please select an image.";
	returnNow();
}

// Check if file already exists
if (file_exists($target_file)) 
{
    $_SESSION["notice"] = "File already exists.";
    returnNow();
}



// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) 
{
    $_SESSION["notice"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    returnNow();
}

// Try to upload
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) 
{
    /* Insert into database */
    $sql = "INSERT INTO images (path_filename, extension)
    		VALUES ('$target_file_local', '$imageFileType');";

    $result = $database->query($sql);

    if ($result['success'])
    {
    	$_SESSION["notice"] = "Image has successfully been uploaded!";
    	returnNow();

    }
    else
    {
    	unlink($target_file);	// Remove the file
    	$_SESSION['notice'] = "Query failed with error: " . $result['error'];
    	returnNow();
	}

} 
else 
{
	$_SESSION["notice"] = "Image not uploaded!";
    returnNow();
}

returnNow();


function returnNow()
{
	header("Location: ../media.php");		// Could just move header() to the beginning and call
	exit();									// exit each time instead...
}

?>