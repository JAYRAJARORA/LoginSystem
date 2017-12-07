 <?php
 //  making connection to execute queries on the db
require 'dbConnection.php';
//  checking if form has been submitted
if(isset($_POST['username'])) { 
	$username = htmlentities(mysqli_escape_string($db,$_POST['username']));
	$password = htmlentities(mysqli_escape_string($db,$_POST['password']));
	$errors = array();//errors array to store different errors for different fields
	// validate username
	function validateUsername($db,&$errors,$username) {
		$err ='';
		if(empty($username)) {
			$err .= 'Username is required';
		} 
		else {
			$query = "SELECT username FROM users WHERE username = '$username' LIMIT 1";
			$check = mysqli_query($db,$query);
			if(!$check || !$check->num_rows){
				$err .= "Username doesnt exists";
			}
		}
		if (''!=$err) {
			$errors['username'] = $err;
		}
 	}
 	// validate password
	function validatePassword($db,&$errors,$password) {
		$err = '';
		if(empty($password)) {
			$err .= 'Password is required';
		}
		if (''!=$err) {
		$errors['password'] = $err;
		}
	}
	// check in the db if record exist else display error
	function validateCombination($db,&$errors,$username,$password) {
		$err = '';
		$password = md5($password);
		$query = "SELECT id FROM users WHERE username='$username' AND password='$password' LIMIT 1";
		$query_status = mysqli_query($db,$query);
		if(!$query_status || !$query_status->num_rows) {
					$err .= 'Wrong Username or Password';
					$errors['invalid'] = $err;
		}
		else {
			// no errors then redirect to the home page
			$user_id = $query_status->fetch_assoc();
			$_SESSION['user_id'] = $user_id['id'];
			header('Location: /../views/home.view.php');
		}
	}
	// calling validation functions
	validateUsername($db,$errors,$username);
	validatePassword($db,$errors,$password);
	if(!$errors){
		validateCombination($db,$errors,$username,$password);
	}
	// errors present then redirect to login page
	if($errors){

		$_SESSION['login_errors'] = $errors;
		header('Location: /../views/login.view.php');
	}
}
