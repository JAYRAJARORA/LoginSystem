<?php
// starting the session 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// connecting to database 
$db = mysqli_connect('localhost', 'root', 'mindfire', 'dashboard');

//checking connection
if (!$db) {
	echo "Couldnt connect to the db";    
}
