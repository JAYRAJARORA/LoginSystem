<?php

require __DIR__ . '/../../views/layouts/header.php';
require __DIR__ . '/../../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location:/../../views/login.view.php');
}

/* consumer key and secret key taken from my twitter app */
define('CONSUMER_KEY', 'UJ5j8DHdpy2LiFTAi3efopos0');
define('CONSUMER_SECRET', 'ZZ3IwigGTTKDoGYweDSJ0Ifx66vLl8XPxHfk6tUS8Z8nKRstDB');
define('OAUTH_CALLBACK', 'http://dashboard.dev/app/twitterapi/callback.php');

/**
 * checking if access token not set meaning if user has not logged in to view tweets
 * making connection to the twiiter auth and generating access token and secret key
 * for authentication by redirecting it to callback.php
 * then redirecting the app to authorization url
 * to validate username and password otherwise
 * user already has the token and logged in so make connections
 * and retrieve the tweets
 */
if (!isset($_SESSION['access_token'])) {
    $connection = new TwitterOAuth(
            CONSUMER_KEY,
            CONSUMER_SECRET
    );
    $request_token = $connection->oauth(
            'oauth/request_token',
            array('oauth_callback' => OAUTH_CALLBACK)
    );
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    $url = $connection->url(
            'oauth/authorize',
            array('oauth_token' => $request_token['oauth_token'])
    );
    header("location: $url");
} else {
    $access_token = $_SESSION['access_token'];
    $connection = new TwitterOAuth(
            CONSUMER_KEY,
            CONSUMER_SECRET,
            $access_token['oauth_token'],
            $access_token['oauth_token_secret']
    );
    $statuses = $connection->get(
            'statuses/user_timeline',
            ['count' => 25, 'exclude_replies' => true]
    );
    $_SESSION['user_tweets'] = $statuses;
}
?>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h1>Your Tweets</h1>
            <!-- checking for tweets if any displaying them in a list -->
            <?php
            if (isset($_SESSION['user_tweets'])
                && !empty($_SESSION['user_tweets'])
            ) {
            ?>
            <ul class="list-group">
                <?php
                foreach ($_SESSION['user_tweets'] as $tweet) {
                ?>
                <li class="list-group-item"><?php echo $tweet->text ?></li>
                <?php } ?>
            </ul>
            <?php } ?>
        </div>
    </div>
</div>
<script>$('#getTweets').addClass('active');</script>
<?php
require __DIR__ . '/../../views/layouts/footer.php';;
?>

