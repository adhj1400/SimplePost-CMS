<?php
include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php');
?>

<div class="container">
	<div class="row">
		<div class="wide-table">
			<div class="inner-box">
				<div class="title-box">Theme Select</div>
				<div class="content">
					<?php 
					$ThemeHandler = new ThemeHandler();
					$ThemeHandler->showThemeSelector();
					?>

					<div class="tiny-msg">
						<p><i><b>Adding new themes</b> <br>Adding a new theme requires admin privileges and access to the root directory (by presumably the FTP). Add a new theme by creating a subfolder inside the Theme directory. Then create a new folder called "config.php" and place:</i></p>
						<p style="color: gray;"><i>Theme Name: -Theme name- <br>
						Author: -Your name- <br>
						Description: -Your description- <br>
						Version: 1.0 </i></p>
						<p><i>... in the beginning of this file.</i></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('includes/sp-footer.php'); ?>
