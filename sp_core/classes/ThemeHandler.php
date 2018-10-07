<?php

/**
 * Theme handling the themes.
 * 
 * @author Adam Hjernquist
 */
class ThemeHandler
{
	/**
	 * Print the theme selections available.
	 * 
	 */
	function showThemeSelector()
	{
		$themeDir = $_SERVER['DOCUMENT_ROOT'] . "/themes/";
		$dirs = scandir($themeDir, 1);
		$themeInfoArray = array();

		// Unset unnecessary entries added to the array through scandir
		unset($dirs[count($dirs) - 1]);
		unset($dirs[count($dirs) - 1]);

		// ´Dig through the directories tryin to find config files
		foreach($dirs as $dir)
		{
			$subdirs = scandir($themeDir . $dir, 1);

			$titles = array(0 =>'Theme Name',
							1 =>'Author',
							2 =>'Description',
							3 =>'Version');

			// Find config.php
			if(array_search('config.php', $subdirs))
			{
				// Dig intro the config file and print all info
				// also link to changing theme
				$myfile = fopen($themeDir . $dir . "/config.php", "r") or die("Unable to open file!");

				// Output one line until end-of-file
				$count = 0;
				$themeArray = array();

				// Loop each info within config.php
				while(!feof($myfile)) 
				{
					$line = fgets($myfile);

					// parse the line - find predefined variables
					// add to themeInfoArray
					foreach($titles as $title)
					{
						if (strpos($line, $title) !== false)
						{
							$pos = strpos($line, $title);	// Get position
							$substring = substr($line, strpos($line, ":") + 2); // Create substring
							$themeArray[$title] = $substring; // Insert into themearray
						}
					}
				}

				// Save the theme realpath
				$themeArray["Path"] = "themes/".$dir;

				// Put it into the containing array
				$themeInfoArray[$dir] = $themeArray;

				fclose($myfile);
			}
		}

		// Print info inside $themeInfoArray
		$a = "";

		try
		{
			$s = file_get_contents($_SERVER['DOCUMENT_ROOT']."/sp_core/resources/settings/theme");
  			$a = unserialize($s);
  		}
  		catch(Exception $e)
  		{
  			// Do nothing
  		}

		echo "<form action='includes/sp-change_theme.php' method='post'>";

		foreach($themeInfoArray as $array)
		{
			if ($a == $array["Path"])
			{
				echo "<button class='themebox-focused' name='path' value='" . $array["Path"] . "'>";
			}
			else
			{
				echo "<button class='themebox' name='path' value='" . $array["Path"] . "'>";
			}?>

			<p><b><?= $array['Theme Name'] ?></b></p>
			<p style='color: gray;'><i>Author: <?= $array['Author']; ?></i></p>
			<p><?= $array['Description']; ?></p>
			<p style='color: gray;'><i>Version: <?= $array['Version']; ?></i></p>
			<a class='preview-box' href='../<?= $array["Path"] ?>' 
				target='_blank'>Preview</a>
			</button>
			<?php
		}
		echo "</form>";
	}

}