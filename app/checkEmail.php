<?php
/**
 * Created by PhpStorm.
 * User: jayraja
 * Date: 20/12/17
 * Time: 1:35 AM
 */
require 'errorCheck.php';
require 'dbConnection.php';

use function fields\error\validateEmail;

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
