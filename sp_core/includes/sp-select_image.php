<div id="floating-box">
	<div id="floating-content">
		<div id="floating-content-inner">
			<p>Select an image</p>

			<!-- Image grid -->
			<?php 
			$imageHandler = new ImageHandler(); 
			$imageHandler->displayGrid($database, false, true, "small", 0);
			?>

		</div>
		<div id="floating-content-inner">
			<button class="button" id="right" 
					onclick="hideElement(getElementById('floating-box')); 
							 insertImage()" >
					Insert
			</button>
			<button class="button" id="right" 
					onclick="hideElement(getElementById('floating-box'))">
					Cancel
			</button>
		</div>
	</div>
</div>