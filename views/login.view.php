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

</head>
<body>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form name="login"
                  method="post"
                  action="/../app/login.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text"
                           class="form-control"
                           id="username"
                           placeholder="Enter username"
                           name="username">
                    <span class=" hide_username_details help-block"
                          id="username_check">
                        <label class="control-label"></label>
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
                            id="submit">Submit
                    </button>
                    &nbsp; <a href="register.view.php">Create Account</a>
                    &nbsp; <button type="button"
                              class="btn btn-primary"
                              data-toggle="modal"
                              data-target="#pwdModal">Forgot Password
                      </button>
                </div>
            </form>
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
                <fieldset>
                    <div class="form-group">
                        <input class="form-control input-lg"
                               placeholder="E-mail Address"
                               name="email"
                               id="modal_email"
                               type="email">
                        <span class=" hide_error help-block"
                              id="display_errors">
                            <label class="control-label"></label>
                        </span>

                    </div>
                    <div class="form-group">
                        <input class="btn btn-lg btn-primary btn-block"
                               value="Send Email"
                               id="forgot_pass_submit"
                               type="submit">
                    </div>
                    <div class="alert alert-success success_box">
                        <span id="successMessage">
                            <label class="control-label"></label>
                        </span>
                    </div>
                </fieldset>

            </div>
            <!-- footer -->
            <div class="modal-footer">
                <button class="btn"
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

