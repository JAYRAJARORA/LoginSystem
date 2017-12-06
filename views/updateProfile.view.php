<?php
// rendering navigation bar in the page
require __DIR__ . '/layouts/header.php';
// starting session 

require __DIR__.'/../app/dbConnection.php'; 
// filling the edit profile fields with old fields
if(isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])) {
    $query = "SELECT firstname,lastname,email,password FROM users WHERE id='" . $_SESSION['user_id'] . "'";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
    $_SESSION['previous_firstname'] = $row['firstname'];
    $_SESSION['previous_lastname'] = $row['lastname'];
    $_SESSION['previous_email'] = $row['email'];
    }  
// rendering style in the page
// checking for errors if present destroy the session after saving it.
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION["errors"]);
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <title></title>
</head>
<body>
<div class="container">
    <h1>Edit Profile</h1>
    <hr>
      <!-- edit form columns -->
      <div class="col-md-9 personal-info">
        <!-- Account information -->
        <h3>Personal info</h3>
        <form method="post" action="/../../app/updateProfile.php" class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">First name:</label>
            <div class="col-lg-8">
              <input class="form-control" name="firstname" type="text" value="<?php if(isset($_SESSION['previous_firstname'])){echo $_SESSION['previous_firstname'];}?>">
                    <!--  checking for errors if any,showing errors using inline php -->
                <?php if (isset($errors['firstname']) && !empty($errors['firstname'])) { ?>
                <div class="has-error"><label class="control-label">
                  <?php echo $errors['firstname']; ?></label>
                </div>
                <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Last name:</label>
            <div class="col-lg-8">
              <input class="form-control" name="lastname" type="text" value="<?php if(isset($_SESSION['previous_lastname'])){echo $_SESSION['previous_lastname'];}?>">
              <?php if (isset($errors['lastname']) && !empty($errors['lastname'])) { ?>
              <div class="has-error"><label class="control-label">
                <?php echo $errors['lastname']; ?></label>
              </div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" name="email" "type="Email" value="<?php if(isset($_SESSION['previous_email'])){echo $_SESSION['previous_email'];}?>">
              <?php if (isset($errors['email']) && !empty($errors['email'])) { ?>
                    <div class="has-error"><label class="control-label">
                    <?php echo $errors['email']; ?></label>
                    </div>
                    <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">OldPassword:</label>
            <div class="col-md-8">
              <input class="form-control" name="old_password" type="password" value="">
              <?php if (isset($errors['old_password']) && !empty($errors['old_password'])) { ?>
                    <div class="has-error"><label class="control-label">
                         <?php echo $errors['old_password']; ?></label>
                    </div>
                    <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label">NewPassword:</label>
            <div class="col-md-8">
              <input class="form-control" name="new_password" type="password" value="">
              <?php if (isset($errors['new_password']) && !empty($errors['new_password'])) { ?>
                    <div class="has-error"><label class="control-label">
                         <?php echo $errors['new_password']; ?></label>
                    </div>
                    <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-3 control-label"></label>
            <div class="col-md-8">
              <!-- save change to the db and redirect to the updateProfile.php -->
              <input type="submit" class="btn btn-primary" value="Save Changes" name="submit">
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
  </div>
</div>
<hr>
</body>
</html>






