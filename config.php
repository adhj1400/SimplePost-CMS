<?php

// Set to match your database
define('DB_SERVER', 'example.123.com');
define('DB_DATABASE', 'database_name');
define('DB_USERNAME', 'your_db_username');
define('DB_PASSWORD', 'your_db_password');
define('DB_TYPE', 'MySQL');


/**
 * Do not alter anything below
 **************************************/

$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/sp_core/sp-config.php";
include_once($path);
?>