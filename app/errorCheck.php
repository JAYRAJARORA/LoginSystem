<?php
/**
 * Created by PhpStorm.
 * User: jayraja
 * Date: 18/12/17
 * Time: 12:42 PM
 */
namespace fields\error;

/**
 * This method checks the username.
 *
 * @param object $db database to hold connections,
 * @param string $username for checking username
 * @param array $errors reference of errors in username
 *
 * @return void
 */
function validateUsername($db, &$errors, $username)
{
    $err = '';

    if (strlen($username) > 40) {
        $err .= 'Maximum length exceeded<br>';
    }

    if (empty($username)) {
        $err .= 'Username is required<br>';
    } elseif (
        !preg_match(
        '/^[0-9a-zA-Z_]{3,}$/',
        $username
        )
    ) {
        $err .= 'Username must be bigger than 3 chars and contain only 
        digits, letters and underscore';
    }

    // checking if user already exists
    $check_query_name = "SELECT Username FROM users WHERE username = '$username'";
    $check = mysqli_query(
        $db,
        $check_query_name
    );

    if ($check && $check->num_rows) {
        $err .= 'Username already exists';
    }

    if ('' !== $err) {
        $errors['username'] = $err;
    }
}

/**
 * This method checks the firstname.
 *
 * @param object $db database to hold connections,
 * @param string $first_name for checking firstname
 * @param array $errors reference of errors in firstname
 *
 * @return void
 */
function validateFirstname(&$errors, $first_name)
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

/**
 * This method checks the lastname.
 *
 * @param string $last_name for checking lastname
 * @param array $errors reference of errors in lastname
 *
 * @return void
 */
function validateLastname(&$errors, $last_name)
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

/**
 * This method checks the email.
 *
 * @param object $db database to hold connections,
 * @param string $email for checking email
 * @param array $errors reference of errors in email
 *
 * @return void
 */
function validateEmail(&$errors, $email)
{
    $err = '';

    if (strlen($email) > 40) {
        $err .= 'Maximum length exceeded<br>';
    }

    if (empty($email)) {
        $err .= 'Email is required<br>';
    } elseif (
        !filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
        )
    ) {
        $email_err = 'Invalid email format';
        $err .= 'Invalid email';
    }
    /* checking for the duplicated email */
    $check_query_email = "SELECT email FROM users WHERE email = '$email'";
    $check = mysqli_query(
        $db,
        $check_query_email
    );

    if ($check && $check->num_rows) {
        $err .= 'Email already exists';
    }

    if ('' !== $err) {
        $errors['email'] = $err;
    }
}

/**
 * This method checks the password.
 *
 * @param object $db database to hold connections,
 * @param string $password for checking password
 * @param array $errors reference of errors in password
 *
 * @return void
 */
function validatePassword(&$errors, $password)
{
    $err = '';

    if (empty($password)) {
        $err .= 'Password is required';
    } elseif (strlen($password) > 32) {
        $err .= 'Maximum length exceeded';
    } elseif (
        !preg_match(
            '/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/',
            $password
        )
    ) {
        $err .= 'Password must be at least 8 characters and must contain 
                at least one lower case letter, one upper case letter and one digit';
    }

    if ('' !== $err) {
        $errors['password'] = $err;
    }
}

/**
 * This method checks the first password is valid and matches
 * with the password_check.
 *
 * @param object $db database to hold connections,
 * @param string $password for checking  if password exists
 * @param string $password_check for checking the password again
 * @param array $errors reference of errors in password_check
 *
 * @return void
 */
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

/**
 * This method checks the first password is valid and matches
 * with the password_check.
 *
 * @param object $db database to hold connections,
 * @param string $password for checking  if password exists
 * @param string $password_check for checking the password again
 * @param array $errors reference of errors in password_check
 *
 * @return void
 */
function validateCombination($db, &$errors, $username, $password)
{
    $err = '';
    $password = md5($password);
    $query = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $query_status = mysqli_query(
        $db,
        $query
    );

    if (!$query_status || !$query_status->num_rows) {
        $err .= 'Wrong Username or Password';
        $errors['invalid'] = $err;
    } else {
        $user_id = $query_status->fetch_assoc();
        $_SESSION['user_id'] = $user_id['id'];
        header('Location: /../views/home.view.php');
    }
}

/**
 * This method checks the old password and username while changing the password
 *
 * @param object $db database to hold connections,
 * @param string $username for checking the username exists,
 * @param string $password for checking  if password exists,
 * @param array $errors reference of errors in password_check
 *
 * @return void
 */
function validateOldPassword($db, &$errors, $username, $old_password)
{
    $err = '';
    $password = $old_password;
    $password = md5($password);
    $query = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $query_status = mysqli_query(
        $db,
        $query
    );

    if (!$query_status || !$query_status->num_rows) {
        $err .= 'Wrong Password Entered';
        $errors['old_password'] = $err;
    }
}