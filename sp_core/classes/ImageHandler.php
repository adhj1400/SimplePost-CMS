<?php

/**
 * Class handling viewing of stored images in the CMS.
 *
 * @author Adam Hjernquist
 */
class ImageHandler 
{
	/**
	 * Display the grid of images in the CMS.
	 *
	 * @param db 			The database instance to perform on
	 * @param removable 	If image can be deleted
	 * @param selectable 	If image can be selected
	 * @param size 			CSS #id style images
	 * @param amount 		How many image to show (0 : show all)
	 */
	function displayGrid(&$db, $removable, $selectable, $size, $amount)
	{
		// Get all image info
		$result = $db->query("SELECT * FROM images;");
		$onclick = "";
		
		// If the image should be selectable e.g. when inserting
		if ($selectable)
		{
			$onclick = "storeFilePath(this);";
		}

		// If there is no images in the database
		if($result['affected_rows'] == 0)
		{
        	echo "No media!";
		}

		// Work with each row
		foreach($result['rows'] as $row)
        { ?>
	        <div class='image-container' id='<?= $size; ?>'>
		        <img src="<?= $row['path_filename']; ?>" 
		        	 onclick="<?= $onclick; ?>"/>
		        
		        <?php
		        if ($removable)
		        {
		        	// Try displaying the image, else empty.
			        try
			        {
			        	$this->displayImage($row);
					}
					catch(Exception $e)
					{ ?>
						<span style="padding: 20px;">Image not found</span>
						<span style="padding: 20px;">ERROR_CODE: 404</span>
					<?php
					} 

					?>
					<div class='shadow'></div>

					<!-- Remove media button -->
			        <form action='media.php' method='post'>
						<button type='submit' name='delete' 
						class='remove-button-triangle' 
						value="<?= $row['image_id']; ?>"/>
					</form> <?php
				} ?>
	        </div>
        <?php
        }
	}

	/**
	 * Display an image from a database result row. Show image meta inside 
	 * the image.
	 *
	 * @param row 	The array with info
	 */
	private function displayImage($row)
	{
		$filename = basename($row['path_filename']);
        $filesize = (int)(filesize($row['path_filename'])/1000);
        $dimensionArray = getimagesize($row['path_filename']);
        $width = $dimensionArray[0];
        $height = $dimensionArray[1];
        $format = substr(strrchr($dimensionArray["mime"], "/"), 1);
        $colorBits = $dimensionArray["bits"]; ?>

        <!-- Image meta information -->
    	<table class="image-meta">
    		<tr>
    			<th>Name:</th>
    			<th><?= $filename; ?></th>
    		</tr>
    		<tr>
    			<th>Size:</th>
    			<th><?= $filesize; ?>KB</th>
    		</tr>
    		<tr>
    			<th>Width:</th>
    			<th><?= $width; ?>px</th>
    		</tr>
    		<tr>
    			<th>Height:</th>
    			<th><?= $height; ?>px</th>
    		</tr>
    		<tr>
    			<th>Dim:</th>
    			<th><?= $width . "x" . $height; ?></th>
    		</tr>
    		<tr>
    			<th>Format:</th>
    			<th><?= $format . ", " . $colorBits . "bit color"; ?></th>
    		</tr>
    	</table> <?php 
	}

}

?>