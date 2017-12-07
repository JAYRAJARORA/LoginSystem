<?php
// starting the session
session_start();
// requrie files to style the page and use twitteroauth class
require __DIR__ . '/../../views/layouts/header.php';
require __DIR__.'/../../vendor/autoload.php';
if(!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
	header('Location:/../../views/login.view.php');
}
use Abraham\TwitterOAuth\TwitterOAuth;
define('CONSUMER_KEY', 'UJ5j8DHdpy2LiFTAi3efopos0'); // consumer key taken from my twitter app 
// consumer secret key from my twitter app
define('CONSUMER_SECRET', 'ZZ3IwigGTTKDoGYweDSJ0Ifx66vLl8XPxHfk6tUS8Z8nKRstDB'); 

define('OAUTH_CALLBACK', 'http://dashboard.dev/app/twitterapi/callback.php'); // my app callback URL
// checking if access token not set meaning if user has not logged in to view tweets
if (!isset($_SESSION['access_token'])) {
	// making connection
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	// generating access token and secret key for authentication by redirecting it to the callback.php
	$request_token = $connection->oauth('oauth/request_token', 
		array('oauth_callback' => OAUTH_CALLBACK));
	$_SESSION['oauth_token'] = $request_token['oauth_token'];
	$_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
	// authorization url to validate username and password 
	$url = $connection->url('oauth/authorize', array('oauth_token' => $request_token['oauth_token']));
	header("location: $url");
} else {
	// user already has the token and logged in 
	$access_token = $_SESSION['access_token'];
	// making connection 
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, 
		$access_token['oauth_token'], $access_token['oauth_token_secret']);
	// retrieving the 25 tweets of the user 
	$statuses = $connection->get("statuses/user_timeline", 
		["count" => 25, "exclude_replies" => true]);
 	$_SESSION['user_tweets'] = $statuses;
}
?>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h1>Your Tweets</h1>
            <!-- checking for tweets if any displaying them in a list -->
            <?php if(isset($_SESSION['user_tweets'])&& !empty($_SESSION['user_tweets'])){?>
            	<ul class="list-group">
            	<?php foreach ($_SESSION['user_tweets'] as $tweet) {?>
            		<li class="list-group-item"><?php echo $tweet->text?></li>	
            	<?php } ?>
            	</ul>
            <?php } ?>
        </div>
    </div>
</div>
<?php
require __DIR__ . '/../../views/layouts/footer.php';;
?>

