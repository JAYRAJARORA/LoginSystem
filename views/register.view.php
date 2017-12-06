<?php 
// starting session 
if(isset($_SESSION))
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
    <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign Up</h2>
            <form method="post" action="/../app/register.php" name="register" onsubmit="">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" 
                    placeholder="Enter Username" name="username" maxlength="40" 
                    value="<?php if(isset($_SESSION['username'])){echo $_SESSION['username'];}?>">
                    <!-- checking for errors if any,showing errors using inline php-->
                    <?php 
                    if (isset($errors['username']) && !empty($errors['username'])) { 
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['username']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="firstname">FirstName:</label>
                    <input type="text" class="form-control" id="firstname" 
                    placeholder="Enter FirstName" name="firstname" maxlength="40" 
                    value="<?php if(isset($_SESSION['firstname'])){ echo $_SESSION['firstname'];}?>">
                    <?php
                    if(isset($errors['firstname'])&& !empty($errors['firstname'])){
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['firstname']; ?></label></div>
                    <?php }?>
                </div>
                <div class="form-group">
                    <label for="lastname">LastName:</label>
                    <input type="text" class="form-control" id="lastname" 
                    placeholder="Enter LastName" maxlength="40" name="lastname" 
                    value="<?php if(isset($_SESSION['lastname'])){echo $_SESSION['lastname'];}?>">
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
                    value="<?php if(isset($_SESSION['email'])){echo $_SESSION['email'];}?>">
                    <?php 
                    if (isset($errors['email']) && !empty($errors['email'])) { 
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['email']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" 
                    placeholder="Enter password" name="password">
                    <?php 
                    if (isset($errors['password']) && !empty($errors['password'])) { 
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['password']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="pwd">Confirm Password:</label>
                    <input type="password" class="form-control" id="pwd" 
                    placeholder="Enter password again" name="password_check">
                    <?php 
                    if (isset($errors['password_check']) && !empty($errors['password_check'])) { 
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['password_check']; ?></label></div>
                    <?php } ?>
                </div>
                <!-- link for signin for already registered user -->
                <div class="form-group form-inline">
                    <button type="submit" class="btn btn-default" name="signup_button">Submit</button>
                    &nbsp; Already have an account<a href = "login.view.php">
                    Sign In</a> Here!
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>

</body>
</html>
