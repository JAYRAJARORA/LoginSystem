<?php

require __DIR__ . '/../app/dbConnection.php';

/* starting session */
if (!isset($_SESSION))
    session_start();

/*retreiving the token
  if token exists in the db and time of the link
    is less than 1 hr then show the page
    else show the link has been expired or token mismatch.
*/
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$_SESSION['token'] = substr(strrchr($actual_link, '='), 1);

if (empty($_SESSION['token'])
    && empty($_SESSION['errors'])
) {
    header('Location:/../views/login.view.php');
}

/* checking for errors if present destroy all the session variables after saving errors. */
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

$epoch = time();
$current_time = date(
        'Y-m-d H:i:s',
        $epoch
);
$query = "SELECT token_time FROM users WHERE forgot_pass_id ='" . $_SESSION['token'] . "' ";

$user = mysqli_query($db, $query);

if ($user->num_rows > 0) {
    $row = $user->fetch_assoc();
    $submit_link_time = $row['token_time'];
    $datetime1 = new DateTime($submit_link_time);
    $datetime2 = new DateTime($current_time);
    $interval = $datetime1->diff($datetime2);
    $difference_in_seconds = strtotime($current_time) - strtotime($submit_link_time);

    if (($difference_in_seconds / 3600) > 1) {
        echo '<div>Link expired.Click on forgot password to reset it again 
                <a href = \'login.view.php\'>Login Page</a>
                </div>';
    } else {
        require 'layouts/header.php';
        ?>

        <body>
        <div class="container">
            <div class="row">
                <div class=" col-md-offset-4 col-md-4">
                    <h2>Reset Password</h2>
                    <form name="reset_password"
                          method="post"
                          action="/../app/resetPassword.php">
                        <div class="form-group">
                            <label for="password">New Password:</label>
                            <input type="password"
                                   class="form-control"
                                   id="password"
                                   placeholder="Enter New Password"
                                   name="password">
                            <span class=" hide_password_details help-block"
                                  id="password_error">
                        <label class="control-label">
                        </label>
                    </span>
                            <?php
                            if (isset($errors['password'])
                                && !empty($errors['password'])
                            ) {
                            ?>
                                <div class="has-error">
                                    <label class="control-label">
                                    <?php echo $errors['password']; ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group">
                            <label for="password_check">Confirm New Password:</label>
                            <input type="password"
                                   class="form-control"
                                   id="password_check"
                                   placeholder="Confirm New Password"
                                   name="password_check">
                            <span class=" hide_password_check_details help-block"
                                  id="password_check_error">
                                <label class="control-label">
                                </label>
                            </span>
                            <?php
                            if (isset($errors['password_check']) && !empty($errors['password_check'])) {
                                ?>
                                <div class="has-error">
                                    <label class="control-label">
                                    <?php
                                    echo $errors['password_check'];
                                    ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="form-group form-inline">
                            <button type="submit"
                                    class="btn btn-default"
                                    name="reset_button"
                                    id="submit">Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script type="text/javascript" src="/../public/js/reset.js"></script>
        </body>
        <?php require 'layouts/footer.php';
    }
} else {
    echo '<div>Token mismatch.Click on forgot password to reset it again 
          <a href = \'login.view.php\'>Login Page</a>
          </div>';
}
?>

