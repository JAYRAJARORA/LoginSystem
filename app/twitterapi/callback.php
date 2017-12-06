<?php
session_start();
// load the file to make connections to the twitteroauth library
require 'twitteroauth/autoload.php';
// library required
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'UJ5j8DHdpy2LiFTAi3efopos0'); 
define('CONSUMER_SECRET', 'ZZ3IwigGTTKDoGYweDSJ0Ifx66vLl8XPxHfk6tUS8Z8nKRstDB');

// checking the user access token and secret key which is coming in the request
if (isset($_REQUEST['oauth_verifier'], $_REQUEST['oauth_token']) &&
	$_REQUEST['oauth_token'] == $_SESSION['oauth_token']) {
	
	$request_token = [];
	$request_token['oauth_token'] = $_SESSION['oauth_token'];
	$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, 
		$request_token['oauth_token'], $request_token['oauth_token_secret']);
	// authorizing the user
	$access_token = $connection->oauth("oauth/access_token", 
		array("oauth_verifier" => $_REQUEST['oauth_verifier']));
	$_SESSION['access_token'] = $access_token;
	// redirect user back to index page
	header('Location: getTweets.php');
}