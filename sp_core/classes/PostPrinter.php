<?php

/**
 * Class handler for displaying posts in a variety of ways.
 * 
 * @author 	Adam Hjernquist <athjernquist@gmail.com>
 */
class PostPrinter
{
	/**
	 * Display post previews in a <ul>-list fashion.
	 *
	 * @param db 		Database instance to work on
	 * @param amount 	Number of posts to display
	 */
	function displayPreviewTable(&$db, $amount)
	{
		$sql = "SELECT * FROM posts 
				WHERE date >= DATE(NOW()) - INTERVAL $amount DAY";
		$result = $db->query($sql);
		
		if (!$result['success'])
	    {
	    	echo $result['error'];
	    	return;
	    }

	    // Flip the array and print it
        foreach(array_reverse($result['rows']) as $row)
        { ?>
        	<form action="edit.php?id=<?= $row['post_id']; ?>" method='post'>
        	<ul>
        		<li>
	        		<span>
	        			<?= date('j M, Y H:m', strtotime($row['date'])); ?>
	        		</span>
					<button class='to-text' type='submit' name='edit-post' 
					value="<?= $row['post_id']; ?>"> 
						<?= $row['titel']; ?> </button>
        		</li>
        	</ul>
        	</form>
        <?php
        }
	}

	/**
	 * Display contents posts in of <table> in a <tr>, <td> style.
	 *
	 * @param db 	The databas to perform on 
	 */
	function displayTable(&$db)
	{
		$sql = "SELECT * FROM posts ORDER BY date";
		$result = $db->query($sql);

		if($result['affected_rows'] == 0)
		{ ?>
			<tr class='wide'>
        		<td class='wide'>No posts!</td>
        	</tr> <?php
		}

		// Print the array in reverse order (newer posts above)
		foreach(array_reverse($result['rows']) as $row)
        {
        	// Set parameters
        	$users_fk = $row['users_fk'];
        	$sql = "SELECT username FROM users WHERE user_id='$users_fk'";
        	$date_publish = date('j M, Y H:i', strtotime($row['date']));
        	$date_edit = date('j M, Y H:i:s', strtotime($row['edit_date']));
        	$user = $db->getSingleEntry($sql);

        	// If there are no edits -> do not show
        	if ($row['date'] == $row['edit_date']) 
        	{
        		$date_edit = "";
        	} ?>
        	
	        <!-- Table of posts -->
            <tr class="wide">
	        	<td class="wide">
	        		<form action="edit.php?id=<?= $row['post_id']; ?>" 
	        			  method="post">
						<button class="to-text" type="submit" name="edit-post" 
								value="<?= $row['post_id']; ?>">
							<?= $row['titel']; ?>
						</button>
					</form>
				</td>

	        	<td style="font-style: italic;" class="wide">
	        		<?= $user; ?></td>
	        	<td style="color:#a5a5a5;" class="wide">
	        		<?= $date_publish; ?></td>
			    <td style="color:#a5a5a5;" class="wide">
			    	<?= $date_edit; ?></td>
	        	<td class="wide"><!-- Comment --></td>

		        <td class="wide">
		        	<?php 
		        	// Show if published or not
		        	if ($row['status'] == 1) 
		        	{ ?>
		        		<p style="color:#336933;">Published</p> <?php 
		        	}
		        	else
		        	{ ?>
		        		<p style="color:#ff0000;"><b>Unpublished<b/></p> <?php
		        	} ?>
		        </td>

		        <td class="wide">
			        <form action="posts.php" method="post">
			        	<button type="submit" name="submit" class="remove-button" 
			        			value="<?= $row['post_id']; ?>"/>
			        </form>
		        </td>
	        </tr>
        <?php 
    	}
	}
	
}

?>