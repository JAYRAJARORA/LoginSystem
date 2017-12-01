<?php
//  making connection to execute queries on the db
require 'dbConnection.php';
//  checking if form has been submitted
if (isset($_POST['username'])) {
    $username       = htmlentities(mysqli_real_escape_string($db, $_POST['username']));
    $email          = htmlentities(mysqli_real_escape_string($db, $_POST['email']));
    $password       = htmlentities(mysqli_real_escape_string($db, $_POST['password']));
    $first_name     = htmlentities(mysqli_real_escape_string($db, $_POST['firstname']));
    $last_name      = htmlentities(mysqli_real_escape_string($db, $_POST['lastname']));

    $errors = array();//errors array to store different errors for different fields
    class errorsCheck {
        // validate username
        function validateUsername($db, &$errors, $username) {
        	$err = '';
        	if  (strlen($username) > 40) {
            	$err .= 'Maximum length exceeded<br>';
        	}
        	if (empty($username)) {
            	$err .= 'Username is required<br>';
        	}
            else if(preg_match("/^[0-9a-zA-Z_]{5,}$/", $username) === 0) {
                $err .= 'Username must be bigger than 5 chars and contain only 
                digits, letters and underscore';
            }
            // checking if user already exists
        	$check_query_name = "SELECT Username FROM users WHERE username = '$username'";
        	$check = mysqli_query($db, $check_query_name);
        	if ($check && $check->num_rows) {
            	$err .= 'Username already exists';
        	}    	
    	
    		if ('' !== $err) {
    			$errors['username'] = $err;
    		}

        }
        // validate firstname of the user
        function validateFirstname($db, &$errors, $first_name) {
        	$err = '';
        	if(strlen($first_name)>40){
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
        function validateLastname($db, &$errors, $last_name) {
        	$err = '';
            if(strlen($last_name)>40){
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
        function validateEmail($db, &$errors, $email) {
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
            // checking for the duplicated email
        	$check_query_email = "SELECT email FROM users WHERE email = '$email'";
        	$check = mysqli_query($db, $check_query_email);
        	if ($check && $check->num_rows) {
            	$err .= 'Email already exists';
        	}	

        	if ('' !== $err) {
        		$errors['email'] = $err;
        	}
         }
        
         // checking for strong password
        function validatePassword($db, &$errors, $password){
        	$err = '';
        	if (empty($password)) {
            	$err .= 'Password is required<br>';
        	}
        	else if(strlen($password)>32) {
            	$err .= 'Maximum length exceeded';
        	}
            else if(!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
                $err .= 'Password must be at least 8 characters and must contain 
                at least one lower case letter, one upper case letter and one digit';
            }
        	if ('' !== $err) {
        		$errors['password'] = $err;
        	}
        }
    }
    // calling various function of the error class
    $ob = new errorsCheck();
    $ob->validateUsername($db, $errors, $username);
    $ob->validateFirstname($db, $errors, $first_name);
    $ob->validateLastname($db, $errors, $last_name);
    $ob->validatePassword($db, $errors, $password);
    $ob->validateEmail($db, $errors, $email);


    // checking for different errors if not set the session variable accordingly
    if(empty($errors['username'])) {
        $_SESSION['username'] = $username;
    }
    if(empty($errors['firstname'])) {
        $_SESSION['firstname'] = $first_name;
    }
    if(empty($errors['lastname'])) { 
        $_SESSION['lastname'] = $last_name;
    }
    if(empty($errors['email'])) {
        $_SESSION['email'] = $email;
    }

    // if errors are present display the errors in the signup page
    if ($errors) {	
    	$_SESSION['errors'] = $errors;
    	header('Location: /../views/register.view.php');
    }
    // insert the record in the db and redirect it to the home page.
    else {
        // storing the hash of the password
    	$password = md5($password);
    	$query = "INSERT INTO users (username, email, password,firstname,lastname) 
            VALUES('$username', '$email', '$password','$first_name','$last_name')";
        // if inserted
    	$query_status= mysqli_query($db, $query);
    	if($query_status){
    		$_SESSION['user_id'] = $db->insert_id;
      		header('Location:/../views/home.view.php');
    	}
	}
}