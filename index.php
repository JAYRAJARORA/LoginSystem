<?php
require_once 'app/dbConnection.php';

if (isset($_SESSION['username'])) {
	header('Location: views/home.php');
} else {
	header('Location: views/login.view.php');
}

