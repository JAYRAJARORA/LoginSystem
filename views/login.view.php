<?php
/* starting the session if the session doesnt exist */
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_id'])) {
    header('Location: home.view.php');
}
/* styling the page with a navigation bar at the header */
require 'layouts/header.php';
/* checking for errors if present destroy the session after saving it. */
if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])) {
    $errors = $_SESSION['login_errors'];
    session_destroy();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="/../public/css/resetPage.css">
</head>
<body>
<script src="/../public/js/fb.js"></script>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form name="login"
                  method="post"
                  action="/../app/login.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="text"
                           class="form-control"
                           id="email"
                           placeholder="Enter email"
                           name="email">
                    <span class=" hide_email_details help-block"
                          id="email_check">
                    </span>

                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           placeholder="Enter password"
                           name="password">
                    <span class="hide_password_details help-block" id="password_error">
                        <?php
                        if (isset($errors['invalid'])
                            && !empty($errors['invalid'])
                        ) {
                            echo $errors['invalid'];
                        } ?>
                    </span>
                </div>

                <div class="form-group form-inline">
                        <button type="submit"
                                class="btn btn-default"
                                name="login_button"
                                id="submit">Submit</button>&nbsp;
                    &nbsp;   <a href="register.view.php">Create Account </a>&nbsp;
                        <a href="#" data-toggle="modal"
                           data-target="#pwdModal">Forgot Password</a>
                </div>
            </form>
                <p>OR</p>
                <div class="fb-login-button"
                     data-max-rows="1"
                     data-size="medium"
                     data-button-type="continue_with"
                     data-show-faces="false" data-auto-logout-link="false"
                     data-use-continue-as="false"
                     scope="public_profile,email"
                     onlogin="checkLoginState();">
                </div>
                <p id="status"></p>

        </div>
    </div>
</div>
<!--modalform-->
<div class="modal fade" id="pwdModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Reset Password</h3>
            </div>
            <!-- body(form) -->
            <div class="modal-body">
                <form class="form-inline">
                    <div class="form-group">
                        <span id="successMessage" class='help-block'></span>
                        <label for="email">Email:</label>
                            <input type="email"
                                   class="form-control"
                                   id="modal_email"
                                   placeholder="Enter email"
                                   name="email">
                            <span class="help-block" id="display_errors">
                            </span>
                    </div>
                </form>


            </div>
            <!-- footer -->
            <div class="modal-footer">
                <button type="submit"
                        id="forgot_pass_submit"
                        class="btn btn-default btn-primary">Send Email</button>&nbsp;
                <button class="btn btn-default btn-danger"
                        data-dismiss="modal"
                        aria-hidden="true">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>
<?php
require 'layouts/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/../public/js/login.js">
</script>
<?php
if (empty($errors['invalid'])
) {?>
    <script>
        $('#password_error').hide();
    </script>
<?php
} else { ?>
    <script>
        $('#password').parent().addClass('has-error');
    </script>
    <?php
    }?>
</body>
</html>

