<?php
$page_title = "Blog Feed";
include("includes/header.php");
include("includes/blogmenu.php");

$posts = getPosts(0, 10, "date"); // Array of posts

?>

<div id="wrapper-blog">
	<div class="container-blog">

		<?php foreach($posts as $post) {?>
			<!-- Post -->
			<section class="post">
				<?php 
				$text = strip_tags($post["text"]);
				$textSize = 200;
				if (strlen($text) > $textSize)
   					$text = substr($text, 0, $textSize - 3) . '...';
				if($post['image'] != "") 
				{ ?>
					<div class="thumbnail">
						<a href="post.php?id=<?= $post['post_id'];?>">
							<img src="data:image/jpeg;base64,<?= base64_encode($post['image'])?>"/>
						</a>
					</div>
				<?php
				}
				?>
				<section id="post-content">
	            	<h2><a href="post.php?id=<?= $post['post_id'];?>">
	            	<?= $post["titel"]; ?></a></h2>
	            	<!-- Post text, stripped of tags -->
	            	<p><?= $text; ?></p>
	            	
            	</section>
            	<div class="post-meta">
            		<span><?= $post["author"]; ?></span>
            		<span>
            			<?= date("Y-m-d", strtotime($post["date"])); ?>
            		</span>
            	</div>
            </section>
		<?php } ?>

	</div>

	<?php include("includes/sidebar.php"); ?>
</div>

<?php include("includes/footer.php"); ?>