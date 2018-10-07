/***********************************************************
  *	Used to create a parallax scrolling effect for element 
  * backgrounds with the class name "parallax".
  **********************************************************/


  // Notice: the background image need to be box-shaped

/**
  *	Scroll <element> background.
  */
function scrollElement(element)
{
	//var pixelLength = ((element.getBoundingClientRect().top) / (900)) * (element.clientHeight - 1900) + "px";

	var speed = 700;

	var pixelLength = (element.getBoundingClientRect().top / 900) * (speed * -1) + "px";

	element.style.backgroundPositionY = pixelLength;

	var windowHeight = window.innerHeight;

	if (windowHeight > 900)
	{
		element.style.height = windowHeight + "px";
		//$(element).animate({height: windowHeight + "px"});
	}


}

/**
  * Initate and iterate scrollElement for the element length.
  */
function scroll()
{
	var element = document.getElementsByClassName("parallax");

	for(var i = 0; i < element.length; i++) 
	{
		scrollElement(element[i]);
	}
};

/**
  *	Set initial height
  */
window.onload = function()
{
	scroll();
}

/**
  *	Runs when scrolling. (unsure about mobile users...)
  */
window.onscroll = function()
{
	scroll();
}

/**
  *	Runs when window is resized.
  */
window.onresize = function()
{
	scroll();
}
