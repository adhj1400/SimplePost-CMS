<?php
if (isset($_SESSION["notice"]) && "" !== $_SESSION["notice"])
{
	$string = $_SESSION["notice"];
	unset($_SESSION["notice"]); 

	?>
	<div id="alert-message">
		<div class="message">
			<?= htmlspecialchars($string); ?>
		</div>
	</div>
	<?php
}

?>
