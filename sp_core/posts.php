
<?php

include('includes/sp-header.php');
include('includes/sp-topbar.php');
include('includes/sp-sidebar.php');

if(isset($_POST["submit"]))
{
	//delete post with post_id $_POST["submit"]
	$sql = "DELETE FROM posts WHERE post_id ='" . $_POST["submit"] . "';";

	$database->query($sql);
}

?>

<!-- HTML -->
<div class="container">
	<div class="row">
		<form action="edit.php">
			<input class="button" type="submit" value="Add new post"/>
		</form>
	</div>

	<div class="row">
		<div class="wide-table">
			<div class="inner-box">
				<div class="title-box">
					Posts (<?php $result = $database->query("
							SELECT * FROM posts;");
						echo $result['affected_rows'];?>)
				</div>
		
				<div id="content-grid">
					<table id="post-table" cellspacing="0">
						<thead>
							<tr class="toprow">
								<td class="column">Title</td>
								<td class="column">Author</td>
								<td class="column">Date (UTC)</td>
								<td class="column">Edited</td>
								<td class="column">Comments</td>
								<td class="column">Visibility</td>
								<td class="column">Delete</td>
							</tr>
						</thead>

						<tbody>
							<!-- Print table -->
							<?php 
							$postPrinter = new PostPrinter();
							$postPrinter->displayTable($database); 
							?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('includes/sp-footer.php'); ?>