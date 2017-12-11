<?php
require 'dbConnection.php';

if(!isset($_SESSION['user_id'])) {
    header('Location:/../../views/login.view.php');
}

if (isset($_POST['submit'])) {
    $email = htmlentities(mysqli_real_escape_string($db, $_POST['email']));
    $old_password = htmlentities(mysqli_real_escape_string($db, $_POST['old_password']));
    $new_password = htmlentities(mysqli_real_escape_string($db, $_POST['new_password']));
    $first_name = htmlentities(mysqli_real_escape_string($db, $_POST['firstname']));
    $last_name = htmlentities(mysqli_real_escape_string($db, $_POST['lastname']));
    $address = htmlentities(mysqli_real_escape_string($db, $_POST['address']));
    $city = htmlentities(mysqli_real_escape_string($db, $_POST['city']));
    $state = htmlentities(mysqli_real_escape_string($db, $_POST['state']));
    $pincode = htmlentities(mysqli_real_escape_string($db, $_POST['zip']));
    $gender = htmlentities(mysqli_real_escape_string($db, $_POST['optradio']));

    // echo $username.' '.$first_name.' '.$last_name.' '.$address.' '.$email.' '.$pincode.' '.$city.' '.$state.' '.$gender.' '.$old_password.' '.$new_password;
    // exit();
    $errors = array();//errors array to store different errors for different fields
    // checking if no data entered so retrun back to the home page without any database hit
    if ($email===$_SESSION['previous_email'] 
    	&& $first_name===$_SESSION['previous_first_name'] 
    	&& $last_name === $_SESSION['previous_last_name'] 
    	&& $old_password===''
    ) {
        header('Location/../views/home.view.php');
    }
    // retrieving username to retrieve the password of that user id.
    // retrieving email to check email entered is not same as previous email(for checking email already exists)
    $query = "SELECT username,email FROM users WHERE id='" . $_SESSION['user_id'] . "'LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
    $username = $row['username'];
    $previous_email = $row['email'];

    class ErrorsCheck 
    {
        //validate firstname of the user
        function validateFirstname($db, &$errors, $first_name) 
        {
        	$err = '';
        	if (strlen($first_name)>40) {
            	$err.='Maximum length exceeded<br>';
        	}
        	if (empty($first_name)) {
            	$err .= 'FirstName is required<br>';
        	}
        	if ('' !== $err) {
        		$errors['firstname'] = $err;
        	       
            }
        }

        //  validate lastname of the user
        function validateLastname($db, &$errors, $last_name) 
        {
        	$err = '';
            if(strlen($last_name)>40) {
            	$err .= 'Maximum length exceeded<br>';
        	}
        	if (empty($last_name)) {
            	$err .= 'LastName is required<br>';
        	}
        	if ('' !== $err) {
        		$errors['lastname'] = $err;
        	}
        }

        // validate email id of the user
        function validateEmail($db, &$errors,$email,$previous_email) 
        {
        	$err = '';
        	if(strlen($email)>40){
            	$err .= 'Maximum length exceeded<br>';
        	}
        	if (empty($email)) {
            	$err .= 'Email is required<br>';
        	}
        	else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            	$email_err = 'Invalid email format';
            	$err .= 'Invalid email';
        	}
            // if email is not changed skip it
            if($previous_email!=$email){
            	$check_query_email = "SELECT email FROM users WHERE email = '$email'";
            	$check = mysqli_query($db, $check_query_email);
            	if ($check && $check->num_rows) {
                	$err .= 'Email already exists';
            	}	
            	if ('' !== $err) {
            		$errors['email'] = $err;
            	}
            }
        }

        // checking for the old password
        function validateOldPassword($db, &$errors, $username, $old_password) 
        {
            $err = '';
            $password = $old_password;
            $password = md5($password);
            $query = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
            $query_status = mysqli_query($db,$query);
            if(!$query_status || !$query_status->num_rows) {
                        $err .= 'Wrong Password Entered';
                        $errors['old_password'] = $err;
            }
        }

        // checking for new password
        function validateNewPassword($db, &$errors, $new_password) 
        {
            // if old password is incorrect then first correct it
        	if (!array_key_exists('old_password', $errors)) {
                $err = '';
                $password = $new_password;
            	if (empty($password)) {
                	$err .= 'Password is required<br>';
            	} else if(strlen($password)>32) {
                	$err .= 'Maximum length exceeded';
            	} else if(!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
                    $err .= 'Password must be at least 8 characters and must contain 
                    at least one lower case letter, one upper case letter and one digit';
                }
            	if ('' !== $err) {
            		$errors['new_password'] = $err;
            	}
            }
        }
    }
    // calling various function of the error class
    $ob = new ErrorsCheck();
    $ob->validateFirstname($db, $errors, $first_name);
    $ob->validateLastname($db, $errors, $last_name);
    $ob->validateEmail($db, $errors, $email,$previous_email);
    // if field empty then do not update passwords
    if(!empty($old_password)) {
        $ob->validateOldPassword($db, $errors, $username, $old_password);
        $ob->validateNewPassword($db, $errors, $new_password);
    }
        
    // if errors are present display the errors in the update view page
    if ($errors) {	
    	$_SESSION['errors'] = $errors;
    	header('Location: /../views/updateProfile.view.php');
    } else {
        // if user also wants to change password
        if (!empty($old_password)) {
        // storing the hash of the password
            $password = md5($new_password);
            $query = "UPDATE users SET firstname='$first_name',lastname='$last_name'
            ,email='$email',password='$password',address='$address',gender='$gender',city='$city',state='$state', zip='$pincode' WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
        } else {
            // if user doesnt want to change password
            $query = "UPDATE users SET firstname='$first_name',lastname='$last_name'
            ,email='$email',address='$address',gender='$gender',city='$city',state='$state', zip='$pincode' WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
        }   
        $query_status = mysqli_query($db, $query);
        if($query_status) {
            // echo '<script>alert("Profile updated successfully")</script>';
            // echo '<script>window.location("/../views/home.view.php")</script>';
            header('Location:/../views/home.view.php');
        }
    }
} elseif(isset($_POST['cancel'])) {
	// hitting cancels reloads the current page so that all fields are reset.
    header("Refresh:0");
} 
?>

