<?php $postArray = getPosts(0, 5, "date"); ?>

<section class="sidebar">
	<div class="sidebar-widget">
		<h3>Recent Posts</h3>
		
		<?php 
		foreach ($postArray as $post)
		{ ?>
			<div class="sidebar-widget-entry">
				<?php
				if($post['image'] != "") 
				{ ?>
					<div class="small-thumbnail">
						<a href="post.php?id=<?= $post['post_id'];?>">
							<img src="data:image/jpeg;base64,<?= base64_encode($post['image'])?>"/></a>
					</div> <?php
				} ?>
				
				<div class="float-spanners">
					<span><a href="post.php?id=<?= $post['post_id']?>">
						<b><?= $post["titel"]; ?></b></a></span>
					<span><?= "Author: " . $post["author"]; ?></span>
				</div>
			</div> <?php 
		} ?>
	</div>

	<div class="sidebar-widget">
		<p>Have a nice day!</p>
	</div>
</section>