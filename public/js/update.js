// form validation using jquery
$(document).ready(function(){
$('#submit').click(function(){
	var error = 0;
	$('.error').hide();
	var firstname = $('#firstname').val();
	var alphabet_regex = /^[A-Za-z]+$/;
	if(firstname=='') {
		$('#firstname').after('<span class="error has-error"><label class="control-label">'+
			'Please enter your firstname</span>');
			error = 1;
		}else if(!alphabet_regex.test(firstname)) {
		$('#firstname').after('<span class="error has-error"><label class="control-label">'+
			'Firstname can have Letters only</span>');
			error = 1;
		}
	var lastname = $('#lastname').val();
	if(lastname=='') {
		$('#lastname').after('<span class="error has-error"><label class="control-label">'+
			'Please enter your lastname</span>');
			error = 1;
		}else if(!alphabet_regex.test(lastname)) {
		$('#lastname').after('<span class="error has-error"><label class="control-label">'+
			'Lastname can have Letters only</span>');
			error = 1;
		}
	var email = $('#email').val();
	if(email==''){
		$('#email').after('<span class="error has-error"><label class="control-label">'+
			'Please enter your email</span>');
			error = 1;
	}
	var pincode = $('#zip').val();
	var pincode_regex = /^[0-9]+$/;
	if(pincode=='') {
		$('#zip').after('<span class="error has-error"><label class="control-label">'+
			'Please enter the pincode</span>');
			error = 1;
		} else if(!pincode_regex.test(pincode)){
		$('#zip').after('<span class="error has-error"><label class="control-label">'+
			'Pincode can have numbers only</span>');
			error = 1;	
	}
	var city = $('#city').val();
	if(''===city){
		$('#city').after('<span class="error has-error"><label class="control-label">'+
			'Please enter the City </span>');
			error = 1;	
	} else if(!alphabet_regex.test(city)){
		$('#city').after('<span class="error has-error"><label class="control-label">'+
			'City can have letters only</span>');
			error = 1;	
	}
	// validate password
	var password = $('#password').val();
	var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
	if(''!==password){
		if(!password_regex.test(password)){
			$('#password').after('<span class="error has-error"><label class="control-label">'+
				'Password must be at least 8 characters and must contain '+
				'at least one lower case letter, one upper case letter and one digit </span>');
			error = 1;
		}
	}
	// validate the again password
	var password_check = $('#password_check').val();
	if(''!==password){
		if(''===password_check ){
			$('#password_check').after('<span class="error has-error"><label class="control-label">'+
				'Please enter the Password Again</span>');
				error = 1;
		} else if(!password_regex.test(password_check)){
			$('#password_check').after('<span class="error has-error"><label class="control-label">'+
				'Password must be at least 8 characters and must contain '+
				'at least one lower case letter, one upper case letter and one digit </span>');
				error = 1;
		}else if(password!=password_check){
			$('#password_check').after('<span class="error has-error"><label class="control-label">'+
			'The two password do not match </span>');
				error = 1;
		}
	}
	if(error==1){return false;}
});
});