function formValidation(){
	var username = document.forms["register"]["username"].value;
	var firstname = document.forms["register"]["firstname"].value;
	var lastname = document.forms["register"]["lastname"].value;
	var email = document.forms["register"]["email"].value;
	var password = document.forms["register"]["password"].value;
	var password_check = document.forms["register"]["password_check"].value;
	if(username=="") {
		alert("Username cant be empty");
		return false;
	}
	if(firstname=="") {
		alert("FirstName cant be empty");
		return false;
	}
	if(lastname=="") {
		alert("Lastname cant be empty");
		return false;
	}
	if(email=="") {
		alert("Email cant be empty");
		return false;
	}
	if(password=="") {
		alert("Password cant be empty");
		return false;
	}	
}