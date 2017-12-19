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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/../public/js/login.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form name="login"
                  method="post"
                  action="/../app/login.php"
                  onsubmit="return formValidation();">
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
                    <?php
                    if (isset($errors['username'])
                        && !empty($errors['username'])) {
                    ?>
                    <div class="has-error">
                        <label class="control-label">
                        <?php echo $errors['username']; ?>
                        </label>
                    </div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password"
                           class="form-control"
                           id="password"
                           placeholder="Enter password"
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
                                <?php
                                echo $errors['password'];
                                ?>
                            </label>
                        </div>
                    <?php
                    }
                    if (isset($errors['invalid'])
                        && !empty($errors['invalid'])
                    ) {
                        ?>
                        <div class="has-error">
                            <label class="control-label">
                                <?php echo $errors['invalid']; ?>
                            </label>
                        </div>
                    <?php } ?>
                </div>

                <div class="form-group form-inline">
                    <button type="submit"
                            class="btn btn-default"
                            name="login_button"
                            id="submit">Submit
                    </button>
                    &nbsp; <a href="register.view.php">Create Account</a>
                    &nbsp; <a href="#"
                              data-target="#pwdModal"
                              data-toggle="modal">
                            Forgot my password</a>
                </div>
            </form>
        </div>
    </div>
</div>
<!--modalform-->
<div id="pwdModal"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true">×
                </button>
                <h1 class="text-center">What's My Password?</h1>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="text-center">
                                <p>If you have forgotten your password
                                    you can reset it here.</p>
                                <div class="panel-body">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12">
                    <button class="btn"
                            data-dismiss="modal"
                            aria-hidden="true">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require 'layouts/footer.php';
?>
</body>
</html>

