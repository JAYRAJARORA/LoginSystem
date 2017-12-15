<?php
// making connections to the db
require 'dbConnection.php';
if (isset($_POST['reset_button'])) {

    $password = htmlentities(mysqli_real_escape_string($db, $_POST['password']));
    $password_check = htmlentities(mysqli_real_escape_string($db, $_POST['password_check']));

    $errors = array();//errors array to store different errors for different fields

    class ErrorCheck
    {
        // checking the password
        function validatePassword(&$errors, $password)
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
        function validatePasswordCheck(&$errors, $password, $password_check)
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

    $ob = new ErrorCheck();
    $ob->validatePassword($errors, $password);
    $ob->validatePasswordCheck($errors, $password, $password_check);
    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: /../views/resetPassword.view.php');
    } // insert the record in the db and redirect it to the home page.
    else {
        $sql = "SELECT id from users where  forgot_pass_id='" . $_SESSION['token'] . "' ";
        $select_query = mysqli_query($db, $sql);
        $row = $select_query->fetch_assoc();
        if ($select_query->num_rows > 0) {
            // storing the hash of the password
            $password = md5($password);
            $query = " Update users set password='$password'where id='" . $row['id'] . "' ";
            // if inserted make the token as null
            $query_status = mysqli_query($db, $query);
            $token_query = " Update users set forgot_pass_id=NULL where id='" . $row['id'] . "' ";
            $query_run = mysqli_query($db, $token_query);
            header('Location:/../views/login.view.php');
        } else {
            header('Location:/../views/resetPassword.view.php');
        }
    }
}
?>