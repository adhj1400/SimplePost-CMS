
var image_src;
var parent = undefined;

/**
 * Inserts a value onto provided TextArea element at an x-y position.
 *
 * @param myValue	Value to insert
 * @param myField	The textarea element
 * @param startPos 	The start position
 * @param endPos  	The end postition
 */
function insertAtCursor(myField, myValue, startPos, endPos) 
{
	myField.focus();

    // IE support
    if (document.selection) 
    {
        sel = document.selection.createRange();
        sel.text = myValue;
    }

    // MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') 
    {
        
        myField.value = myField.value.substring(0, startPos)
            + myValue
            + myField.value.substring(endPos, myField.value.length);
        myField.selectionStart = startPos + myValue.length;
        myField.selectionEnd = startPos + myValue.length;
    }
    else 
    {
        myField.value += myValue;
    }
}

/**
 * Set positions in a 2D array.
 *
 * @param field 	The field to find selection
 */
function setXYPosition(field)
{
	sessionStorage.setItem("startPos", field.selectionStart);
	sessionStorage.setItem("endPos", field.selectionEnd);
}

/**
 * Hide element.
 *
 * @param element
 */
function hideElement(element)
{
	element.style.display = "none";
}

/** 
 * Insert at specific position inside textarea.
 *
 * @param input
 */
function insertInput(input)
{
	// try to insert
	var startPos = sessionStorage.getItem("startPos");
	var endPos = sessionStorage.getItem("endPos");
	var insertTrue = sessionStorage.getItem("insertTrue");
	insertTrue = true;	// test for now

	if ((startPos !== null) && (endPos !== null) && insertTrue) 
	{
		//alert(startPos + endPos + " inserted"); // Debug

		// clear past entry (if any)
		sessionStorage.clear();

		// insert
		insertAtCursor(document.getElementById('post-content'), input, startPos, endPos);

		// update text-mark position
		setXYPosition(document.getElementById('post-content'));
	}
}


/**
 * Set onclick event listener. Also display or hide TextArea.
 *
 */
$(document).ready(function() 
{
	/* Store the current position of the text-marker inside the textarea */
	$('#post-content').on('keyup click', function()
	{
		setXYPosition(this);
	});

	if (document.getElementById("post-content"))
	{
		if (sessionStorage.getItem("displaymode") !== null)
		{
			if (sessionStorage.getItem("displaymode") === "text")
			{
				displayEditor_Text();
			}
			else
			{
				displayEditor_Html();
			}

		}
		$(document).click(function()
		{
			//Move html data to textarea
			//document.getElementById('post-content').value = document.getElementById('post-content-html').innerHTML;
		});
	}

});


/**
 * Store @image src and color-mark its parent element.
 *
 * @param image
 */
function storeFilePath(image)
{
	image_src = image.src;	// Note: No need to remember during session

	// Parse
	//image_src = image_src.replace(/^.*\/\/[^\/]+/, '')

	// Mark this image as selected
	select(image);
}


/**
 * UI related function, marks parent of element with a colored border.
 *
 * @param element
 */
function select(element)
{
	if (parent !== undefined)
	{
		parent.style.border = "solid 5px transparent";

		if (parent == element.parentElement)
		{
			parent = undefined;
			return;
		}
	}

	parent = element.parentElement;
	parent.style.border = "solid 5px #7e00ae4f";
}

/**
 * Inserts <img> element with source specified i previous steps.
 *
 */
function insertImage()
{
	// Create img src string
	$HTMLstring = "<img src='" + image_src + "' />";

	// insert
	insertInput($HTMLstring);
}

/**
 * Insert HTML paragraph tag element.
 *
 */
function insertParagraph()
{
	insertInput("<p></p>");
}

/**
 * TESTING
 *
 */
function insertYoutubeVideo(url)
{
	$HTMLstring = "<iframe width='420' height='345' src='" + url + "'></iframe>";
	insertInput($HTMLstring);
}

/**
 * Insert HTML <b> tag to make text bold.
 *
 */
function insertBold()
{
	$HTMLstring = "<b></b>";
	insertInput($HTMLstring);
}

/**
 * Insert HTML <center> tag to center text.
 *
 */
function insertCenter()
{
	$HTMLstring = "<center></center>";
}

/**
 * Show the TextArea editor, hides the div HTML viewer.
 *
 */
function displayEditor_Text()
{
	sessionStorage.setItem("displaymode", "text");
	var textElement = document.getElementById('post-content');
	var htmlElement = document.getElementById('post-content-html');
	var textButton = document.getElementById('text-button');
	var htmlButton = document.getElementById('html-button');

	if (htmlElement.style.display !== 'none')
	{
		htmlElement.style.display = 'none';
		textElement.style.display = 'block';

		textElement.value = htmlElement.innerHTML;
		textButton.style.background = "#d9ccff";
		htmlButton.style.background = "white";
	}

}

/**
 * Hide the original TextArea element and show div element instead to view
 * HTML representation.
 *
 */
function displayEditor_Html()
{
	sessionStorage.setItem("displaymode", "html");
	var textElement = document.getElementById('post-content');
	var htmlElement = document.getElementById('post-content-html');
	var textButton = document.getElementById('text-button');
	var htmlButton = document.getElementById('html-button');

	if (textElement.style.display !== 'none')
	{
		htmlElement.style.display = 'block';
		textElement.style.display = 'none';

		htmlElement.innerHTML = textElement.value;

		textButton.style.background = "white";
		htmlButton.style.background = "#d9ccff";
	}
}
