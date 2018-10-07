<?php

// Start session
session_start();

// Constants
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
define('CMS_PATH', ROOT_PATH . '/sp_core/');
define('HOST_PATH', 'http://' . $_SERVER['HTTP_HOST']);
define('SP_VERSION', '1.1a');
define('CMS_NAME', 'SimplePost');
define('THUMBNAIL_MAX_SIZE', '500000');
define('IMAGE_MAX_FILESIZE_B', '3000000');

// The database instance
$database;

// Update to fit tables of the SimplePost database
$tableArray = array("comments", 
                    "images", 
                    "posts",
                    "users");

// Include user config constants
include_once(ROOT_PATH . "/config.php");

/**
 *  Load class when instantiated.
 */
spl_autoload_register(function($class_name) 
{
    // Define class folders
    $class_paths = array("classes", "classes/database");

    // Check each defined folder for class file
    foreach($class_paths as $path)
    {
        $relative_path = $path . "/" . $class_name . ".php";

        // If class file exists, include it
        if (file_exists(CMS_PATH . "/" . $relative_path))
        {
            include_once($relative_path);
        }
    }
});

// Try connecting to the database
try
{
    $database = new MySQLConnection(DB_SERVER, DB_USERNAME, 
        DB_PASSWORD, DB_DATABASE);
}
catch(ErrorException $e)
{
    echo "Error: " . $e->getMessage();
    exit();
}

// Check if ALL standard SP tables exist
$DatabaseRepairer = new DatabaseRepairer($tableArray);

if (!$DatabaseRepairer->checkTables($database))
{
    // Logout current session if any
    if (isset($_SESSION["login_user"]))
    {
        unset($_SESSION["login_user"]);
    }

    // Recreate all tables
    $DatabaseRepairer->createTables($database);

    $_SESSION["new_user"] = "true";
    $_SESSION["fakeload"] = "true";

    $path = "/sp_core/includes/sp-create_user.php";

    header("location: ".HOST_PATH.$path);

    exit();
}

include("theme_functions.php");

?>