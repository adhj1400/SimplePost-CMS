<?php
$page_title = "Blog";
include("includes/header.php");
include("includes/blogmenu.php");

$posts = getPost($_GET["id"]);
?>

<div id="wrapper-blog">
	
	<div class="container-blog">
		<section class="post-page">
			<?php
			if($posts['image'] != "") 
			{ ?>
				<div id="post-thumbnail">
					<img src="data:image/jpeg;base64,<?= base64_encode($posts['image'])?>"/>
					<div class="text-overlay">
						<h1><?= $posts["titel"]; ?></h1>
					</div>
				</div>
			<?php
			}
			else 
			{
				$titel = $posts['titel'];
				echo "<h2 style='position:relative;left:50px;'>$titel</h2>";
			}
			?>
			<section id="post-content">
				<p><?= $posts["text"]; ?></p>
			</section>
			<section id="post-content-meta">
				<span>Written by <?= $posts["author"]; ?></span>
				<span>Published <?= date("Y-m-d", strtotime($posts["date"])); ?></span>
			</section>

		</section>

	</div>

	<?php include("includes/sidebar.php"); ?>

</div>

<?php include("includes/footer.php"); ?>