<?php

require __DIR__ . '/../../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location:/../../views/login.view.php');
}

define('CONSUMER_KEY', 'UJ5j8DHdpy2LiFTAi3efopos0');
define('CONSUMER_SECRET', 'ZZ3IwigGTTKDoGYweDSJ0Ifx66vLl8XPxHfk6tUS8Z8nKRstDB');

/**
 * checking the user access token and secret key which is coming in the request
 * authorizing the user and redirecting the user
 */
if (isset(
    $_REQUEST['oauth_verifier'],
    $_REQUEST['oauth_token']) &&
    $_REQUEST['oauth_token'] == $_SESSION['oauth_token']
) {
    $request_token = [];
    $request_token['oauth_token'] = $_SESSION['oauth_token'];
    $request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
    $connection = new TwitterOAuth(
        CONSUMER_KEY,
        CONSUMER_SECRET,
        $request_token['oauth_token'],
        $request_token['oauth_token_secret']
    );
    $access_token = $connection->oauth(
        'oauth/access_token',
        array('oauth_verifier' => $_REQUEST['oauth_verifier'])
    );
    $_SESSION['access_token'] = $access_token;
    header('Location: getTweets.php');
}