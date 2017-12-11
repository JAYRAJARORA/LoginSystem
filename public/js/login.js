$(document).ready(function()
{
	$('input').focus(function()
	{
		$(this).css("background-color","#d1d1d1");
	});
	$('input').blur(function()
	{
		$(this).css("background-color","#ffffff");
	});
	$('#submit').click(function() 
	{
		var username = $('#username').val();
		var password = $('#password').val();
		$('.error').hide();
		var error = 0;
		if(''===username) {
			$('#username').after('<span class="error has-error"><label class="control-label">'+
			'Please enter the Username </span>');
			error = 1;
		} 
		if(''===password){
			$('#password').after('<span class="error has-error"><label class="control-label">'+
			'Please enter the Password </span>');
			error = 1;
		}
		if(1===error){return false;}
	});
});