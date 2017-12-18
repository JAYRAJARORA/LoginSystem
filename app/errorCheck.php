<?php
/**
 * Created by PhpStorm.
 * User: jayraja
 * Date: 18/12/17
 * Time: 12:42 PM
 */
class ErrorCheck
{
    // validate username
    function validateUsername($db, &$errors, $username)
    {
        $err = '';
        if (strlen($username) > 40) {
            $err .= 'Maximum length exceeded<br>';
        }
        if (empty($username)) {
            $err .= 'Username is required<br>';
        } else if (preg_match('/^[0-9a-zA-Z_]{3,}$/', $username) === 0) {
            $err .= 'Username must be bigger than 3 chars and contain only 
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
    function validateFirstname($db, &$errors, $first_name)
    {
        $err = '';
        if (strlen($first_name) > 40) {
            $err .= 'Maximum length exceeded<br>';
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
        if (strlen($last_name) > 40) {
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
    function validateEmail($db, &$errors, $email)
    {
        $err = '';
        if (strlen($email) > 40) {
            $err .= 'Maximum length exceeded<br>';
        }
        if (empty($email)) {
            $err .= 'Email is required<br>';
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
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

    // checking the password
    function validatePassword($db, &$errors, $password)
    {
        $err = '';
        if (empty($password)) {
            $err .= 'Password is required<br>';
        } else if (strlen($password) > 32) {
            $err .= 'Maximum length exceeded';
        } else if (!preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password)) {
            $err .= 'Password must be at least 8 characters and must contain 
                at least one lower case letter, one upper case letter and one digit';
        }
        if ('' !== $err) {
            $errors['password'] = $err;
        }
    }

    // confirm the password
    function validatePasswordCheck($db, &$errors, $password, $password_check)
    {
        $err = '';
        // if old password is incorrect then first correct it
        if (!array_key_exists('password', $errors)) {
            if ($password !== $password_check) {
                $err .= 'The two passwords do not match';
            }
        }
        if ('' !== $err) {
            $errors['password_check'] = $err;
        }
    }
}