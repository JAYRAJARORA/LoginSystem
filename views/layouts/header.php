<?php

// checking sessions
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/../../public/css/navbar.css">
    <script src="https://use.fontawesome.com/490cd2eb93.js"></script>
    <style>
        .navbar {
            border-radius : 0px;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js">
    </script>
    <title>Login </title>
</head>
<body>
    <nav class="navbar navbar-inverse" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="/../views/home.view.php">Dashboard
                </a>
            </div>
            <!-- displaying the detailed navigation bar only if user has logged in -->
            <?php
            if (isset($_SESSION['user_id'])
                && !empty($_SESSION['user_id'])) {
            ?>
            <ul class="nav navbar-nav">
                <li id="home"><a href="/../views/home.view.php">Home</a></li>
                <li id="update"><a href="/../views/updateProfile.view.php">Edit Profile
                    </a>
                </li>
                <li id="getTweets"><a href="/../../app/twitterapi/getTweets.php">View Tweets
                    </a>
                </li>
            </ul>
            <!-- logout button at the right for logging out the user -->
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/../../app/logout.php?logout=1">
                        <span class="glyphicon glyphicon-log-out">Logout
                        </span>
                    </a>
                </li>
            </ul>
            <?php } ?> 
        </div>
    </nav>