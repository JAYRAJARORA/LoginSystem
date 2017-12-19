<?php
/* making connection to execute queries on the db */
require 'dbConnection.php';
require 'errorCheck.php';

use function fields\error\validateCombination;
/* checking if form has been submitted */
if (isset($_POST['username'])) {
    $username = htmlentities(mysqli_escape_string($db, $_POST['username']));
    $password = htmlentities(mysqli_escape_string($db, $_POST['password']));
    $errors = array();

    validateCombination($db, $errors, $username, $password);

    /* if errors present then redirect to login page */
    if ($errors) {
        $_SESSION['login_errors'] = $errors;
        header('Location: /../views/login.view.php');
    }
}
