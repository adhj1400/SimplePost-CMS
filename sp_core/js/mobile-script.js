/**
 * Mobile JavaScript
 *
 * Provide mobile user-exclusive scripts.
 */

/**
 * Animate the hamburger icon and show the sidebar menu by switching CSS.
 */
function hamburgerClick(burger)
{
	burger.classList.toggle("hamburger-clicked");
	leftMenu = document.getElementById("left-menu");

	leftMenu.classList.toggle("left-menu-clicked");
}
