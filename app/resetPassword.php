<?php

require 'dbConnection.php';
require 'errorCheck.php';

use function \fields\error\validatePassword;
use function \fields\error\validatePasswordCheck;

if (isset($_POST['reset_button'])) {
    $password = htmlentities(mysqli_real_escape_string($db, $_POST['password']));
    $password_check = htmlentities(mysqli_real_escape_string($db, $_POST['password_check']));
    $errors = array();

    validatePassword($errors, $password);
    validatePasswordCheck($errors, $password, $password_check);

    /**
     * if errors present show the errors insert the record in the db and
     * redirect it to the home page.
     */
    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: /../views/resetPassword.view.php');
    } else {
        $sql = "SELECT id from users where  forgot_pass_id='" . $_SESSION['token'] . "' ";
        $select_query = mysqli_query($db, $sql);
        $row = $select_query->fetch_assoc();

        if ($select_query->num_rows > 0) {
            $password = md5($password);
            $query = " Update users set password='$password'where id='" . $row['id'] . "' ";
            /* if inserted make the token as null */
            $query_status = mysqli_query($db, $query);
            $token_query = " Update users set forgot_pass_id=NULL where id='" . $row['id'] . "' ";
            $query_run = mysqli_query($db, $token_query);
            header('Location:/../views/login.view.php');
        } else {
            header('Location:/../views/resetPassword.view.php');
        }
    }
}
