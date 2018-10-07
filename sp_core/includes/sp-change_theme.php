<?php

/** 
 * Serialize settings and store on server 
 */
$serialized = serialize($_POST["path"]);
file_put_contents("../resources/settings/theme", $serialized);


/** 
 * Modify the htaccess file. Change the default theme path.
 * 
 * Note: This is a potential disastrous security risk. However, 
 * we are specifically searching for one line of code and trying 
 * to replace it according to all other changes within the same 
 * file, so this SHOULD be safe. This should be moved to its own 
 * class and the class folders should be unaccesable.
*/
$path = $_SERVER['DOCUMENT_ROOT']."/.htaccess";

file_put_contents($path, implode('', 
  array_map(function($data) 
  {
    // Get Theme name
  	$newTheme = substr($_POST["path"], strrpos($_POST["path"], "/")+1);

    // Create line to insert
    $newLine = "RewriteRule !^themes/" . $newTheme . "/ /themes/" . 
                $newTheme . "/%{REQUEST_URI} [L,NC]\n";

    // Insert
    return stristr($data,'/themes/') ? $newLine : $data;
  }, file($path))
));

// Return to theme page
header('Location: ../themes.php');

?>