<?php
/* making connection to execute queries on the db */
require 'dbConnection.php';
require 'errorCheck.php';

use function fields\error\validateCombination;
/* checking if form has been submitted */
if (isset($_POST['email'])) {
    $email = htmlentities(mysqli_escape_string($db, $_POST['email']));
    $password = htmlentities(mysqli_escape_string($db, $_POST['password']));
    $errors = array();

    validateCombination($db, $errors, $email, $password);

    /* if errors present then redirect to login page */
    if ($errors) {
        $_SESSION['login_errors'] = $errors;
        header('Location: /../views/login.view.php');
    }
}
