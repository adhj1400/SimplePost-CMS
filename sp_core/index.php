<?php
include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php');
?>

<div class="container">
	<div class="row">
		<div class="half">
			<div class="inner-box">
				<div class="title-box">Information</div>
				<div class="content">
					<p><b>Server</b></p>
					<p>SimplePost version: <?= SP_VERSION; ?></p> 
					<p>PHP version: <?= phpversion(); ?></p>
					<p>Apache version: <?= $_SERVER['SERVER_SOFTWARE']; ?></p>
					<p><b>Database</b></p>
					<p>Platform: <?= DB_TYPE . " (v." . $database->getVersion() . ")";?></p>
					<p>Server name: <?= DB_SERVER; ?></p>
					<p>DB Name: <?= DB_DATABASE; ?></p>
				</div>
			</div>
		</div>

		<div class="half">
			<div class="inner-box">
				<div class="title-box">Site Stats</div>
				<div class="content">
					Users: <?php 
						$sql = "SELECT COUNT(*) FROM users;";
						$result = $database->query($sql);  
						echo $result['rows'][0][0]; 
						?>
					<br>
					Posts: <?php 
						$sql = "SELECT COUNT(*) FROM posts;";
						$result = $database->query($sql);  
						echo $result['rows'][0][0];
						?>
					<br>
					Images: <?php 
						$sql = "SELECT COUNT(*) FROM images;";
						$result = $database->query($sql);  
						echo $result['rows'][0][0];
						?>
				</div>
			</div>
		</div>

		<div class="half">
			<div class="inner-box">
				<div class="title-box">Recent Activity</div>
				<div class="content">
					<!-- Recent post activity -->
					<?php 

					if ($result['affected_rows'] == 0)
					{
						echo "No recent activity.";
					}
					else
					{
						echo "<p><b>Last 7 days</b></p>";

						$postPrinter = new PostPrinter();
						$postPrinter->displayPreviewTable($database, 7); 
					}

					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('includes/sp-footer.php'); ?>
