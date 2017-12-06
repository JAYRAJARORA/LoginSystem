<?php
// starting the session if the session doesnt exist 
if(!isset($_SESSION)) { 
    session_start(); 
}

// connecting to database 
$db = mysqli_connect('localhost', 'root', 'mindfire', 'dashboard');

//checking connection else showing error message.
if (!$db) {
	echo "Could'nt connect to the db";    
}
