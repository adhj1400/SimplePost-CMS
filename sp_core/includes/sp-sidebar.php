<div id="left-menu">

<?php

// Add more pages here (.php file => title)
$pages = array(	'index.php'=>'Dashboard', 
				'posts.php'=>'Posts', 
				'media.php'=>'Media',
				'themes.php'=>'Themes',
				'users.php'=>'Users');

$currentpage = basename($_SERVER['SCRIPT_FILENAME']);

// Print all menu items
foreach ($pages as $page => $title) 
{
	$text = "";

	if ($currentpage === $page)
	{
		$text = 'class="active"';
	}

	echo '<form class="option" action="' . $page . '">
			<input type="submit" ' . $text . ' value="' . $title . '"/>
		  </form>';
}
?>

</div>
