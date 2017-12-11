<?php
// rendering navigation bar in the page
require __DIR__ . '/layouts/header.php';
// starting session 

require __DIR__.'/../app/dbConnection.php'; 
// filling the edit profile fields with old fields
if (isset($_SESSION['user_id'])&& !empty($_SESSION['user_id'])) {
    $query = "SELECT firstname,lastname,email FROM users WHERE id='" . $_SESSION['user_id'] . "'
    LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
    $_SESSION['previous_first_name'] = $row['firstname'];
    $_SESSION['previous_last_name'] = $row['lastname'];
    $_SESSION['previous_email'] = $row['email'];
    }
else {
    header('Location: login.view.php');
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="/../public/js/update.js"></script>
    <title>Update Profile</title>
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
                <input class="form-control" name="firstname" type="text" id="firstname" value="<?php if(isset($_SESSION['previous_first_name'])){echo $_SESSION['previous_first_name'];}?>">
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
              <input class="form-control" name="lastname" id="lastname" type="text" value="<?php if(isset($_SESSION['previous_last_name'])){echo $_SESSION['previous_last_name'];}?>">
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
              <input type="email" class="form-control" name="email" id="email" value="<?php if(isset($_SESSION['previous_email'])){echo $_SESSION['previous_email'];}?>">
              <?php if (isset($errors['email']) && !empty($errors['email'])) { ?>
                    <div class="has-error"><label class="control-label">
                    <?php echo $errors['email']; ?></label>
                    </div>
                    <?php } ?>
            </div>
          </div>
          <div class="form-group">
                    <label class="col-lg-3 control-label" for="address">Address:</label>
                    <div class="col-lg-8"><textarea class="form-control" rows="5" id="address" name="address" 
                        placeholder="Enter address here"></textarea></div>        
          </div>
          <div class="form-group">
                    <label class="col-lg-3 control-label" for="state">State:</label>
                    <div class="col-lg-8">
                      <select class="form-control" id="state" name="state">
                        <option>Odhisa</option>
                        <option>Uttar Pradesh</option>
                        <option>Punjab</option>
                        <option>Rajasthan</option>
                      </select>
                      </div>        
          </div>
           <div class="form-group">
                    <label class="col-lg-3 control-label" for="zip">Pincode:</label>
                    <div class="col-lg-8">
                    <input type="text" class="form-control" id="zip" 
                    placeholder="Enter Zipcode" name="zip" maxlength="6">
                    </div>
           </div> 
           <div class="form-group">
                    <label class="col-lg-3 control-label" for="city">City:</label>
                    <div class="col-lg-8"> 
                       <input type="text" class="form-control" id="city" 
                    placeholder="Enter City" name="city" maxlength="20"> 
                    </div>
            </div>
           <div class="form-group">
                    <label class="col-lg-3 control-label" for="Country">Country:</label>
                    <div class="col-lg-8"> 
                    <input type="text" class="form-control" id="Country" 
                    value="India" name="country" disabled> 
                    </div>
            </div>
            <div class="form-group">
                    <label class="col-lg-3 control-label" for="optradio">Gender:</label>
                    <div class="col-lg-8"> 
                    <label class="radio-inline" id="gender">
                        <input type="radio" name="optradio" value="male" checked>Male</label>
                    <label class="radio-inline" id="gender">
                        <input type="radio" name="optradio" value="female">Female</label> 
                    </div>
            </div>         
          <div class="form-group">
            <label class="col-md-3 control-label">OldPassword:</label>
            <div class="col-md-8">
              <input class="form-control" name="old_password" id="password" placeholder="Enter old Password" 
              type="password" value="">
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
              <input class="form-control" name="new_password" id="password_check" type="password" 
              placeholder="Enter New Password" value="">
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
              <input type="submit" class="btn btn-primary" value="Save Changes" id="submit" name="submit">
              <input type="reset" class="btn btn-default" value="Cancel">
            </div>
          </div>
        </form>
      </div>
</div>
<hr>
</body>
</html>






