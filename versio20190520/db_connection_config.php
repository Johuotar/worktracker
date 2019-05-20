<?php
/* Database credentials. */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'worktrackAdmin');
define('DB_PASSWORD', 'WAdmin');

// define('DB_USERNAME', 'Admin');
// define('DB_PASSWORD', 'admin');

define('DB_NAME', 'worktracker');

/* Attempt to connect to MySQL database */
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($mysqli === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

?>