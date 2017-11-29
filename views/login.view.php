<?php 
require 'layouts/header.php';
?>

<div class="container">
    <div class="row">
        <div class=" col-md-offset-4 col-md-4">
            <h2>Sign In</h2>
            <form action="/../app/login.php">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
                </div>


                <div class="form-group form-inline">
                    <button type="submit" class="btn btn-default">Submit</button>
                    &nbsp; New User <a href = "register.view.php">Sign Up</a> Here!
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require 'layouts/footer.php';
?>
