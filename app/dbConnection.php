<?php
// starting the session 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// connecting to database 
$db = mysqli_connect('localhost', 'root', 'mindfire', 'dashboard');

//checking connection else showing error message.
if (!$db) {
	echo "Could'nt connect to the db";    
}
