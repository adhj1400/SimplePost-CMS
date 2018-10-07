<?php
include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php');

$DBTableArchiver = new DBTableArchiver($database);

// Get the URI id variable
$id = isset($_GET["id"]) ? $_GET["id"] : 0;
$src = "";

/* Choose and create Texteditor */
$textEditor = new SimpleEditor($DBTableArchiver, $id);
/* ############################ */

// All variables are inside varArray
$varArray = $textEditor->getVariables();

if(($src = $textEditor->getAndUnset('thumbnail_backup')) != "")
{
	$src = 'data:image/jpeg;base64,' . $src; 
}
elseif($varArray['thumbnail'] != '')
{
	$src = 'data:image/jpeg;base64,' . $varArray['thumbnail']; 
}

// Show upload box if session variable is set
if ($textEditor->getAndUnset("insert") != "")
{
	include("includes/sp-select_image.php");
}

?>

<div class="container">
	<div class="row">
		<form action="posts.php">
			<input class="button" type="submit" value="Discard"/>
		</form>
	</div>

	<div class="row">
		<form action="includes/sp-upload_post.php" method="post" 
			  enctype="multipart/form-data">

			<!-- Hidden POST variables -->
			<input type="hidden" name="update" 
				   value="<?= $varArray['post_id']; ?>"/>
			<input type="hidden" name="thumbnail" id="thumbnail"
				   value="<?= 'data:image/jpeg;base64,'.$varArray['thumbnail']; ?>"/>

			<!-- Content body -->
			<div id="post-body">
				<!-- Left pane -->
				<section id="editor-pane-left">
					<!-- Subject box -->
					<input type="text" value="<?= $varArray['subject']; ?>" 
						   name="subject" id="subject" 
						   placeholder="Subject" rows="1" tabindex="1"/>
					<!-- Editor -->
					<?php $textEditor->printEditor() ?>
				</section>

				<!-- Right pane -->
				<div id="editor-pane-right">
					
					<!-- Submit buttons and widgets -->
					<section class="post-right-widget">
						<div class="image-holder">
	    					<img id="preview-image" alt=" " src="<?= $src; ?>" />
	    					<p>Preview Image</p>
						</div>

						<button type="button" 
								id="remove-image" class="button" 
								onclick="removeURL('preview-image', this);">
								Remove</button>

						<input type="file" id="fileToUpload" 
							   style="color: transparent;width: 100%;"
								name="fileToUpload" tabindex="3" 
								accept="image/png, image/jpeg" 
								onchange="readURL(this)"/>
					</section>

					<!-- Submit section -->
					<section class="post-right-widget">
						<!-- Publish status -->
						<?php $textEditor->printStatus(); ?>
						
						<button id="publish-button" class="button" 
								name="action" value="1" tabindex="4">
								Publish</button>
						<button id="save-button" class="button" 
								name="action" value="0">Save</button>
					</section>
				</div>
			</div>

		</form>
	</div>
</div>

<?php include('includes/sp-footer.php'); ?>