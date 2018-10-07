<!-- This is a fixed overlay box to be included by other php files 
	 It will hover above all other elements on the page -->

<div class="floating-box">
	<div id="floating-content">
		<div id="floating-content-inner">
			<form action="includes/sp-upload_media.php" method="post" 
					enctype="multipart/form-data">
				<input type="file" id="fileToUpload" name="fileToUpload" 
						accept="image/png, image/jpeg, image/gif" />


				<input type="submit" value="Upload Image" name="submit" />
				<input type="submit" value="Cancel" name="cancel" />
			</form>
		</div>
	</div>
</div>
