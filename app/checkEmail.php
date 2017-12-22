<?php
require 'errorCheck.php';
require 'dbConnection.php';

use function fields\error\validateEmail;

/**
 * check email coming from the ajax request call the function validate email
 *  and call validate email and send appropriate message back.
 */
if ($_POST['email']) {

    $email = $_POST['email'];
    $errors = array();
    $response = array();

    validateEmail($db, $errors, $email);

    if($errors) {
        $response['error'] = $errors;
    } else {
        $response['success'] = 'Email is valid';
    }
    echo json_encode($response);
}
