<?php

require 'dbConnection.php';
require 'errorCheck.php';

use function \fields\error\validateFirstname;
use function \fields\error\validateLastname;
use function \fields\error\validateEmail;
use function \fields\error\validateOldPassword;
use function \fields\error\validatePassword as validateNewPassword;

if (!isset($_SESSION['user_id'])) {
    header('Location:/../../views/login.view.php');
}

if (isset($_POST['submit'])) {
    $email = htmlentities(mysqli_real_escape_string($db, $_POST['email']));
    $old_password = htmlentities(mysqli_real_escape_string($db, $_POST['old_password']));
    $new_password = htmlentities(mysqli_real_escape_string($db, $_POST['new_password']));
    $first_name = htmlentities(mysqli_real_escape_string($db, $_POST['firstname']));
    $last_name = htmlentities(mysqli_real_escape_string($db, $_POST['lastname']));
    $address = htmlentities(mysqli_real_escape_string($db, $_POST['address']));
    $city = htmlentities(mysqli_real_escape_string($db, $_POST['city']));
    $state = htmlentities(mysqli_real_escape_string($db, $_POST['state']));
    $pincode = htmlentities(mysqli_real_escape_string($db, $_POST['zip']));
    $gender = htmlentities(mysqli_real_escape_string($db, $_POST['optradio']));
    $errors = array();

    /*checking if no data entered so return back to the home page without any database hit */
    if ($email === $_SESSION['previous_email']
        && $first_name === $_SESSION['previous_first_name']
        && $last_name === $_SESSION['previous_last_name']
        && $address === $_SESSION['previous_address']
        && $pincode === $_SESSION['previous_zip']
        && $city === $_SESSION['previous_city']
        && $old_password === ''
    ) {
        header('Location/../views/home.view.php');
    }
    /*retrieving email to retrieve the password of that user id. */
    /** retrieving email to check email entered is not same
     * as previous email(for checking email already exists)
     * */
    $query = "SELECT email FROM users 
    WHERE id='" . $_SESSION['user_id'] . "'LIMIT 1";
    $user = mysqli_query($db, $query);
    $row = $user->fetch_assoc();
    $previous_email = $row['email'];

    validateFirstname($errors,$first_name);
    validateLastname($errors,$last_name);
    if($email!=$previous_email) {
        validateEmail($db, $errors, $email);
    }
    /* if field empty then do not update passwords */
    if (!empty($old_password)) {
        validateOldPassword($db, $errors, $email, $old_password);
        validateNewPassword($errors, $new_password);
    }

    /* if errors are present display the errors in the update view page */
    if ($errors) {
        $_SESSION['errors'] = $errors;
        header('Location: /../views/updateProfile.view.php');
    } else {
        /* if user also wants to change password */
        if (!empty($old_password)) {
            /* storing the hash of the password */
            $password = md5($new_password);
            $query = "UPDATE users SET firstname='$first_name',lastname='$last_name'".
                ",email='$email',password='$password',address='$address',".
                "gender='$gender',city='$city',state='$state', zip='$pincode'".
                " WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
        } else {
            /* if user doesnt want to change password */
            $query = "UPDATE users SET firstname='$first_name',lastname='$last_name'".
                ",email='$email',address='$address',gender='$gender',city='$city',".
                "state='$state', zip='$pincode' WHERE id='" . $_SESSION['user_id'] . "' LIMIT 1";
        }
        $query_status = mysqli_query($db, $query);

        if ($query_status) {
            header('Location:/../views/home.view.php');
        }
    }
} elseif (isset($_POST['cancel'])) {
    /* hitting cancels reloads the current page so that all fields are reset. */
    header('Refresh:0');
}


