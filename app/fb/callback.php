<?php
require __DIR__ . '/../../vendor/autoload.php';
require __DIR__.'/../dbConnection.php';

use Facebook\Facebook;

$fb = new Facebook([
    'app_id' => '2058930917706396',
    'app_secret' => '608957f7aca31c4d75179176586fcbe6',
    'default_graph_version' => 'v2.11'
]);

/* decode the signed request from the cookie set by the JavaScript SDK.*/
$helper = $fb->getJavaScriptHelper();

/* connecting with the graph api*/
try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    /* When Graph returns an error */
    echo 'Graph returned an error: ' . $e->getMessage();
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    /* When validation fails or other local issues */
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
}

/* check if facebook has successfully verified the users then log the user in */
if (isset($accessToken)) {
    $fb->setDefaultAccessToken($accessToken);
    try {
        $requestProfile = $fb->get(
            "/me?fields=name,email,first_name,last_name,gender"
        );
        $profile = $requestProfile->getGraphNode()->asArray();
    } catch(Facebook\Exceptions\FacebookResponseException $e) {
        /* When Graph returns an error */
        echo 'Graph returned an error: ' . $e->getMessage();
    } catch(Facebook\Exceptions\FacebookSDKException $e) {
        /* When validation fails or other local issues */
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
    }

    $email = $profile['email'];
    $first_name =  $profile['first_name'];
    $last_name = $profile['last_name'];
    $gender = $profile['gender'];

    /**
     * for already registered users login to their account,
     *  for new users insert credentials coming from facebook api,
     *  set other_account_login = 1 for new users
     * and afterwards let them only login with facebook
     */
    $query = "SELECT id FROM users WHERE email='" . $email . "' LIMIT 1";
    $user_status = mysqli_query($db, $query);

    if ($user_status->num_rows >0) {
        $row = $user_status->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        header('Location: /../views/home.view.php');
    } else {
        $fb_user_insert_query = "INSERT INTO users (firstname,lastname,
                      role_id,gender,email,other_account_login) 
                      VALUES ('$first_name','$last_name',1,'$gender','$email',1)";
        $fb_insert_user = mysqli_query($db, $fb_user_insert_query);
        if ($fb_insert_user) {
            $_SESSION['user_id'] = $db->insert_id;
            header('Location:/../views/home.view.php');
        } else {
            header('Location:/../views/login.view.php');
        }
    }
} else {
    echo 'Unauthorized access!!!';
}
