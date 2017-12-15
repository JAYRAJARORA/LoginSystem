<?php
// starting session 
if (isset($_SESSION))
    session_start();
// rendering style in the page
require 'layouts/header.php';
// checking for errors if present destroy all the session variables after saving errors.
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    session_destroy();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>

</head>
<body>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign Up</h2>
            <form name="register" method="post" action="/../app/register.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username"
                           placeholder="Enter Username" name="username" maxlength="40"
                           value="<?php if (isset($_SESSION['username'])) {
                               echo $_SESSION['username'];
                           } ?>">
                    <!-- checking for errors if any,showing errors using inline php-->
                    <span class="hide_username_details help-block"
                          id="username_check">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['username']) && !empty($errors['username'])) {
                        ?>
                        <div class="has-error"><label class="control-label" id="usererror">
                                <?php echo $errors['username']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="firstname">FirstName:</label>
                    <input type="text" class="form-control" id="firstname"
                           placeholder="Enter FirstName" name="firstname" maxlength="40"
                           value="<?php if (isset($_SESSION['firstname'])) {
                               echo $_SESSION['firstname'];
                           } ?>">
                    <span class="hide_firstname_details help-block"
                          id="firstname_check">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['firstname']) && !empty($errors['firstname'])) {
                        ?>
                        <div class="has-error"><label class="control-label">
                                <?php echo $errors['firstname']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="lastname">LastName:</label>
                    <input type="text" class="form-control" id="lastname"
                           placeholder="Enter LastName" maxlength="40" name="lastname"
                           value="<?php if (isset($_SESSION['lastname'])) {
                               echo $_SESSION['lastname'];
                           } ?>">
                    <span class="hide_lastname_details help-block"
                          id="lastname_check">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['lastname']) && !empty($errors['lastname'])) {
                        ?>
                        <div class="has-error"><label class="control-label">
                                <?php echo $errors['lastname']; ?></label></div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email"
                           placeholder="Enter email" maxlength="40" name="email"
                           value="<?php if (isset($_SESSION['email'])) {
                               echo $_SESSION['email'];
                           } ?>">
                    <span class="hide_email_details help-block"
                          id="email_check">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['email']) && !empty($errors['email'])) {
                        ?>
                        <div class="has-error"><label class="control-label">
                                <?php echo $errors['email']; ?></label>
                        </div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <textarea class="form-control" rows="5" id="address" name="address"
                              placeholder="Enter address here"></textarea>
                </div>

                <div class="form-group">
                    <label for="state">State:</label>
                    <select class="form-control" id="state" name="state">
                        <option>Odhisa</option>
                        <option>Uttar Pradesh</option>
                        <option>Punjab</option>
                        <option>Rajasthan</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="zip">Pincode:</label>
                    <input type="text" class="form-control" id="zip"
                           placeholder="Enter Pincode" name="zip" maxlength="6">
                    <span class=" hide_pincode_details help-block"
                          id="pincode_check">
                        <label class="control-label">
                        </label>
                    </span>
                </div>

                <div class="form-group">
                    <label for="city">City:</label>
                    <input type="text" class="form-control" id="city"
                           placeholder="Enter City" name="city" maxlength="20">
                    <span class=" hide_city_details help-block"
                          id="city_check">
                        <label class="control-label">
                        </label>
                    </span>
                </div>

                <div class="form-group">
                    <label for="Country">Country:</label>
                    <input type="text" class="form-control" id="Country"
                           value="India" name="country" disabled>
                </div>

                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <label class="radio-inline" id="gender">
                        <input type="radio" name="optradio" value="male" checked>Male</label>
                    <label class="radio-inline" id="gender">
                        <input type="radio" name="optradio" value="female">Female</label>
                </div>

                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="password"
                           placeholder="Enter password" name="password">
                    <span class=" hide_password_details help-block"
                          id="password_error">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['password']) && !empty($errors['password'])) {
                        ?>
                        <div class="has-error"><label class="control-label">
                                <?php echo $errors['password']; ?></label></div>
                    <?php } ?>

                </div>

                <div class="form-group">
                    <label for="pwd">Confirm Password:</label>
                    <input type="password" class="form-control" id="password_check"
                           placeholder="Enter password again" name="password_check">
                    <span class=" hide_password_check_details help-block"
                          id="password_check_error">
                        <label class="control-label">
                        </label>
                    </span>
                    <?php
                    if (isset($errors['password_check']) && !empty($errors['password_check'])) {
                        ?>
                        <div class="has-error"><label class="control-label">
                                <?php echo $errors['password_check']; ?></label></div>
                    <?php } ?>
                </div>
                <!-- link for signin for already registered user -->
                <div class="form-group form-inline">
                    <button type="submit" class="btn btn-default" name="signup_button" id="submit">Submit</button>
                    &nbsp; Already have an account<a href="login.view.php">
                        Sign In</a> Here!
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="/../public/js/register.js"></script>
</body>
</html>
