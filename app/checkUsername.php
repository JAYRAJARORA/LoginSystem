<?php
/**
 * Created by PhpStorm.
 * User: jayraja
 * Date: 20/12/17
 * Time: 2:12 AM
 */

require 'dbConnection.php';
require 'errorCheck.php';

use function fields\error\validateUsername;

if($_POST['username']) {
    $username = $_POST['username'];
    $errors = array();
    $response = array();
    validateUsername($db, $errors, $username);
    if($errors) {
        $response['error'] = $errors;
    } else {
        $response['success'] = 'Username is valid';
    }
    echo json_encode($response);
}