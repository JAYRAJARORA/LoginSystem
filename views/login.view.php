<?php 
// starting the session if the session doesnt exist 
if(!isset($_SESSION)) { 
    session_start(); 
}
// styling the page with a navigation bar at the header
require 'layouts/header.php';
// checking for errors if present destroy the session after saving it.
if (isset($_SESSION['login_errors']) && !empty($_SESSION['login_errors'])) {
    $errors = $_SESSION['login_errors'];
    session_destroy();
}
// redirect to the home page
if (isset($_SESSION['user_id'])) {
    header('Location: home.view.php');
}
?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form method="post" action="/../app/login.php">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" 
                    placeholder="Enter username" name="username">
                    <?php if(isset($errors['username']) && !empty($errors['username'])) {?>
                     <!-- checking for errors if any,showing errors -->
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['username']; ?></label></div>
                    <?php } ?>
                </div>
                
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="pwd" 
                    placeholder="Enter password" name="password">
                     <?php 
                    if (isset($errors['password']) && !empty($errors['password'])) { 
                    ?>
                    <!-- checking for errors if any,showing errors -->
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['password']; ?></label></div>
                    <?php } ?>
                     <?php 
                    if (isset($errors['invalid']) && !empty($errors['invalid'])) { 
                    ?>
                    <div class="has-error"><label class="control-label">
                        <?php echo $errors['invalid']; ?></label></div>
                    <?php } ?>
                </div>
                <!-- link for signup page for new user-->
                <div class="form-group form-inline">
                    <button type="submit" class="btn btn-default" 
                        name="login_button">Submit</button>
                    &nbsp; New User <a href = "register.view.php">Sign Up</a> Here!
                </div>
            </form>
        </div>
    </div>
</div>
<!-- including the footer style -->
<?php
require 'layouts/footer.php';
?>
