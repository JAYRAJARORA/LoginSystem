<?php
require 'dbConnection.php';

if (isset($_POST['username'])) {
    $username       = mysqli_real_escape_string($db, $_POST['username']);
    $email          = mysqli_real_escape_string($db, $_POST['email']);
    $password       = mysqli_real_escape_string($db, $_POST['password']);
    $first_name     = mysqli_real_escape_string($db, $_POST['firstname']);
    $last_name      = mysqli_real_escape_string($db, $_POST['lastname']);

    $errors = array();
    function validateUsername($db, &$errors, $username){
    	$err = '';
    	if  (strlen($username) > 20){
        	$err .= 'Maximum length exceeded<br>';
    	}
    	if (empty($username)) {
        	$err .= 'Username is required<br>';
    	}
    	else if(strlen($username) < 3){
        	$err .= 'Username is short<br>';
    	}	
    	$check_query_name = "SELECT Username FROM users WHERE username = '$username'";
    	$check = mysqli_query($db, $check_query_name);
    	if ($check && $check->num_rows) {
        	$err .= 'Username already exists';
    	}    	
	
		if ('' !== $err) {
			$errors['username'] = $err;
		}

    }

    function validateFirstname($db, &$errors, $first_name){
    	$err = '';
    	if(strlen($first_name)>20){
        	$err.='Maximum length exceeded<br>';
    	}
    	if (empty($first_name)) {
        	$err .= 'FirstName is required<br>';
    	}

    	if ('' !== $err) {
    		$errors['firstname'] = $err;
    	}
    }
    function validateLastname($db, &$errors, $last_name){
    	$err = '';
        if(strlen($last_name)>20){
        	$err .= 'Maximum length exceeded<br>';
    	}
    	if (empty($last_name)) {
        	$err .= 'LastName is required<br>';
    	}

    	if ('' !== $err) {
    		$errors['lastname'] = $err;	
    	}
    }
    function validateEmail($db, &$errors, $email){
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
    	$check_query_email = "SELECT email FROM users WHERE email = '$email'";
    	$check = mysqli_query($db, $check_query_email);
    	if ($check && $check->num_rows) {
        	$err .= 'Email already exists';
    	}	

    	if ('' !== $err) {
    		$errors['email'] = $err;
    	}
     }
    
    function validatePassword($db, &$errors, $password){
    	$err = '';
    	if (empty($password)) {
        	$err .= 'Password is required<br>';
    	}
    	if(strlen($password)>32){
        	$err .= 'Maximum length exceeded';
    	}

    	if ('' !== $err) {
    		$errors['password'] = $err;
    	}
    }
    validateUsername($db, $errors, $username);
    validateFirstname($db, $errors, $first_name);
    validateLastname($db, $errors, $last_name);
    validatePassword($db, $errors, $password);
    validateEmail($db, $errors, $email);


    if ($errors) {
    	
    	$_SESSION['errors'] = $errors;
    	header('Location: /../views/register.view.php');

    }
  
    else{

    	$password = md5($password);
        
        // echo $password;exit;
        // storing into the database 
    	$query = "INSERT INTO users (username, email, password,firstname,lastname) 
            VALUES('$username', '$email', '$password','$first_name','$last_name')";

    	$query_status= mysqli_query($db, $query);
    	if($query_status){
    		$_SESSION['user_id'] = $db->insert_id;
     		header('Location:/../views/home.view.php');
    	}

	}
}