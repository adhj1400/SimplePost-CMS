<?php

/**
 * Standard implementation of TextEditor. Feel free to edit this to add more
 * functionality.
 *
 */

class SimpleEditor extends TextEditor
{
	/**
	 * Prints the default editor.
	 *
	 */
	function printEditor()
	{
		?>
		<script src="js/image-selection.js"></script>

		<div id="textarea-menu">
			<button class="editormenu-option" type="button" 
					onclick="insertParagraph()">Insert paragraph</button>
			<button class="editormenu-option" type="button" 
					onclick="insertBold()">Bold</button>
			<button class="editormenu-option" value="image" 
					name="insert">Insert image</button>
			<button id="html-button" type="button" style="float:right;" 
					onclick="displayEditor_Html()">HTML</button>
			<button id="text-button" type="button" style="float:right;" 
					onclick="displayEditor_Text()">Text</button>
		</div>

		<!-- Post writing area -->
		<textarea name="post" id="post-content" 
				  tabindex="2"><?= $this->post_content; ?></textarea>

		<div name="post" 
			 id="post-content-html"><?= $this->post_content; ?></div>
		<?php
	}

}


?>