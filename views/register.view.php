<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require 'layouts/header.php';

if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    session_destroy();
}
?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form method="post" action="/../app/register.php" name="register">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" 
                    placeholder="Enter Username" name="username">
                    <?php 
                    if (isset($errors['username']) && !empty($errors['username'])) { 
                    ?>
                    <div class="has-error"><label class="control-label"><?php echo $errors['username']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="firstname">FirstName:</label>
                    <input type="text" class="form-control" id="firstname" 
                    placeholder="Enter FirstName" name="firstname">
                    <?php
                    if(isset($errors['firstname'])&& !empty($errors['firstname'])){
                    ?>
                    <div class="has-error"><label class="control-label"><?php echo $errors['firstname']; ?></label></div>
                    <?php }?>
                </div>
                <div class="form-group">
                    <label for="lastname">LastName:</label>
                    <input type="text" class="form-control" id="lastname" 
                    placeholder="Enter LastName" name="lastname">
                    <?php 
                    if (isset($errors['lastname']) && !empty($errors['lastname'])) { 
                    ?>
                    <div class="has-error"><label class="control-label"><?php echo $errors['lastname']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" 
                    placeholder="Enter email" name="email">
                    <?php 
                    if (isset($errors['email']) && !empty($errors['email'])) { 
                    ?>
                    <div class="has-error"><label class="control-label"><?php echo $errors['email']; ?></label></div>
                    <?php } ?>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" 
                    placeholder="Enter password" name="password">
                    <?php 
                    if (isset($errors['password']) && !empty($errors['password'])) { 
                    ?>
                    <div class="has-error"><label class="control-label"><?php echo $errors['password']; ?></label></div>
                    <?php } ?>
                </div>


                <div class="form-group form-inline">
                    <button type="submit" class="btn btn-default">Submit</button>
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
