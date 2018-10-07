$(document).on('click', 'a[href^="#"]', function (event) 
{
    event.preventDefault();

    var offset = 100;	// How many pixels above the element to focus
    var speed = 600;	// Scroll animation speed

    $('html, body').animate(
    {
        scrollTop: $($.attr(this, 'href')).offset().top - offset

    }, speed);

});
