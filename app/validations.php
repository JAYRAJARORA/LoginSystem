<?php
session_start();
$username            = '';
$email               = '';
$errors              = array();
$_SESSION['success'] = '';
$first_name          = '';
$last_name           = '';


if (isset($_POST['reg_user'])) {
    $username       = mysqli_real_escape_string($db, $_POST['username']);
    $email          = mysqli_real_escape_string($db, $_POST['email']);
    $password_1     = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2     = mysqli_real_escape_string($db, $_POST['password_2']);
    $first_name     = mysqli_real_escape_string($db, $_POST['first_name']);
    $last_name      = mysqli_real_escape_string($db, $_POST['last_name']);
    
    // form validation
    // username validation
    class validations{
    	function validateUsername($username){
    		if (empty($username)) {
        array_push($errors, 'Username is required');
    }
    if(strlen($username)>32){
        array_push($errors, 'Maximum length exceeded');
    }
    if(strlen($username)<3){
        array_push($errors, 'Username is short');
    }		
    	}

    	function validateFirstname($username){
    		if (empty($first_name)) {
        array_push($errors, 'FirstName is required');
    }
        if(strlen($first_name)>20){
        array_push($errors, 'Maximum length exceeded');
    }
    if(strlen($first_name)<2){
        array_push($errors, 'Firstname is short');
    }
    	}
    	function validateLastname($last_name){
    		if (empty($last_name)) {
        array_push($errors, 'LastName is required');
    }
        if(strlen($last_name)>20){
        array_push($errors, 'Maximum length exceeded');
    }
    if(strlen($last_name)<2){
        array_push($errors, 'lastname is short');
    }		
    	}
    function validateEmail($email){
    if (empty($email)) {
        array_push($errors, 'Email is required');
    }
        if(strlen($email)>32){
        array_push($errors, 'Maximum length exceeded');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_err = 'Invalid email format';
        array_push($errors, 'Invalid email');
    	 }	
    	}
    function validatePassword($password_1,$password_2){
    	if (empty($password_1)) {
        array_push($errors, 'Password is required');
    }
    if ($password_1 != $password_2) {
        array_push($errors, 'The two passwords do not match');
    }
    }
    }
     $check_query_name = "SELECT Username FROM users WHERE username = '$username'";
    $check            = mysqli_query($db, $check_query_name);
    if ($check->num_rows) {
        array_push($errors, 'Username already exists');
    }

    $check_query_email = "SELECT email FROM users WHERE username = '$email'";
    $check            = mysqli_query($db, $check_query_name);
    if ($check->num_rows) {
        array_push($errors, 'Email already exists');
    }





    // register user if there are no errors in the form
    if (count($errors) == 0) {
        //encrypt the password before saving in the database
        $password = md5($password_1);
        
        // echo $password;exit;
        // storing into the database 
        $query = "INSERT INTO users (username, email, password,firstname,lastname) 
                  VALUES('$username', '$email', '$password','$first_name','$last_name')";
        mysqli_query($db, $query);
        
        $_SESSION['username']   = $username;
        $_SESSION['first_name'] = $first_name;
        $_SESSION['last_name']  = $last_name;
        $_SESSION['success']    = "You are now logged in";
        // redirecting the page 
        header('location: index.php');
    }
    
}