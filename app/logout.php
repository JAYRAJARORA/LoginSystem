<?php
session_start();
// if logout clicked then destroying all sessions and redirecting to the login page
if(isset($_GET['logout'])) {	
	$_SESSION = array();
	session_destroy();
	header("location: /../views/login.view.php");
}
?>