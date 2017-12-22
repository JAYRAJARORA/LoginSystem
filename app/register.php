<?php

require 'dbConnection.php';
require 'errorCheck.php';

use function \fields\error\validateEmail;
use function \fields\error\validatePassword;
use function \fields\error\validateFirstname;
use function \fields\error\validateLastname;
use function \fields\error\validatePasswordCheck;

/* checking if form has been submitted */
if (isset($_POST['signup_button'])) {
    $email = htmlentities(mysqli_real_escape_string($db, $_POST['email']));
    $password = htmlentities(mysqli_real_escape_string($db, $_POST['password']));
    $first_name = htmlentities(mysqli_real_escape_string($db, $_POST['firstname']));
    $last_name = htmlentities(mysqli_real_escape_string($db, $_POST['lastname']));
    $address = htmlentities(mysqli_escape_string($db, $_POST['address']));
    $zip = htmlentities(mysqli_escape_string($db, $_POST['zip']));
    $city = htmlentities(mysqli_escape_string($db, $_POST['city']));
    $state = htmlentities(mysqli_escape_string($db, $_POST['state']));
    $gender = htmlentities(mysqli_escape_string($db, $_POST['optradio']));
    $password_check = htmlentities(mysqli_real_escape_string($db, $_POST['password_check']));
    $errors = array();

    validateFirstname($errors, $first_name);
    validateLastname($errors, $last_name);
    validateEmail($db, $errors, $email);
    validatePassword($errors, $password);
    validatePasswordCheck($errors, $password, $password_check);

        /**
         * if errors are present display the errors in the signup page
         *  else insert the record in the db and redirect it to the home page
         */
        if ($errors) {
            $_SESSION['errors'] = $errors;
            header('Location: /../views/register.view.php');
        } else {
            $password = md5($password);
            $query = "INSERT INTO users (email,password,firstname,lastname,".
                "address,city,gender,state,zip,role_id) VALUES('$email',".
                "'$password','$first_name','$last_name','$address','$city','$gender',".
                "'$state','$zip',1)";
            /*if inserted */
            $query_status = mysqli_query($db, $query);
            echo $query_status;
            if ($query_status) {
                $_SESSION['user_id'] = $db->insert_id;
                header('Location:/../views/home.view.php');
            } else {
                header('Location:/../views/register.view.php');
            }
        }
}

