// form validation using jquery
$(document).ready(function () {

    // client side validation for password
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();


    function passwordValidate(password, password_regex) {
        if ('' === password) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password is required');
            $('#password_error').show();
            return false;
        } else if (!password_regex.test(password)) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password invalid');
            $('#password_error').show();
            return false;
        }
    }

    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password, password_regex);
    });

    //client side validation for password which is entered again
    var password_check = $('#password_check').val();
    $('.hide_password_check_details').hide();

    function passwordCheckValidate(password, password_check, password_regex) {
        if ('' === password_check) {
            $('#password_check').parent().addClass('has-error');
            $('#password_check_error').html('Password is required');
            $('#password_check_error').show();
            return false;
        } else if (!password_regex.test(password_check)) {
            $('#password_check').parent().addClass('has-error');
            $('#password_check_error').html('Password is invalid');
            $('#password_check_error').show();
            return false;
        } else if (password != password_check) {
            $('#password_check').parent().addClass('has-error');
            $('#password_check_error').html('The two passwords do not match');
            $('#password_check_error').show();
            return false;
        }
    }

    $('#password_check').focus(function () {
        $('#password_check_error').hide();
        $('#password_check').parent().removeClass('has-error');
    });
    $('#password_check').blur(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        passwordCheckValidate(password, password_check, password_regex);
    });

    // checking the fields again upon submit
    $('#submit').click(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        if(false === passwordValidate(password, password_regex) ||
            passwordCheckValidate(password, password_check, password_regex)
        ){
         return false;
        }
    });
});
