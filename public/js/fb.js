function statusChangeCallback(response) {
    /** The response object is returned with a status field that lets the
     *  app know the current login status of the person.
     *  Full docs on the response object can be found in the documentation
     *  for FB.getLoginStatus().
      */
    if (response.status === 'connected') {
        /* Logged into your app and Facebook. */
        window.location.replace('/../../app/fb/callback.php');
    } else if (response.status === 'not_authorized') {
        /* The person is logged into Facebook, but not your app. */
    } else {
        /* The person is not logged into Facebook, so we're not sure if */
        /* they are logged into this app or not. */
    }
}

function checkLoginState() {
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

window.fbAsyncInit = function() {
    /**
     * enable cookies to allow the server to access the session
     * parse social plugins on this page
     * use any version
     */
    FB.init({
        appId      : '2058930917706396',
        cookie     : true,
        xfbml      : true,
        version    : 'v2.11'
    });

};

/* Load the SDK asynchronously */
(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
