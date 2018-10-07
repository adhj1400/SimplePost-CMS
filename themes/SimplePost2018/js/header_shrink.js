var screenOffset = 200;

$(function()
{
    $('#mainheader').data('size','big');
});

/* Set height of the header */
function setHeight(animation_speed)
{
    if($(document).scrollTop() > screenOffset)
    {
        if($('#mainheader').data('size') == 'big')
        {
            $('#mainheader').data('size','small');
            $('#mainheader').stop().animate({
                paddingBottom:'0px', paddingTop:'0px'
            }, animation_speed);

            $('#lefticon').stop().animate({
                fontSize:'18px'
            }, 10);
        }
    }
    else
    {
        if($('#mainheader').data('size') == 'small')
        {
            $('#mainheader').data('size','big');
            $('#mainheader').stop().animate({
                paddingBottom:'25px', paddingTop:'25px'
            }, animation_speed);
            $('#lefticon').stop().animate({
                fontSize:'24px'
            }, 10);
        }  
    }
}

/* Run on scroll */
$(window).scroll(function()
{
    setHeight(400);
});

/* Shrink on page load */
window.onload = function()
{
    setHeight(1)
}
