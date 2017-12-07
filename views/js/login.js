function formValidation(){
	var username = document.forms["login"]["username"].value;
	var password = document.forms["login"]["password"].value;
	if(username=="") {
		alert("Username cant be empty");
		return false;
	}
	if(password=="") {
		alert("Password cant be empty");
		return false;
	}	
}
