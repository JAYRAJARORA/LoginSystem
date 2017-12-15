<?php
//starting the session and making connections to the database
require_once 'app/dbConnection.php';

// if user already logged in show the home page else direct it to signin page
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    header('Location: views/home.view.php');
} else {
    header('Location: views/login.view.php');
}

