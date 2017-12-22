/* form validation using jquery */
$(document).ready(function () {

    /* client side validation for password */
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();


    function passwordValidate(password, password_regex) {
        if ('' === password) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password is required').show();
            return false;
        } else if (!password_regex.test(password)) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password is invalid.Password must ' +
                'be at least 8 characters and must contain at least ' +
                'one lower case letter, one upper case letter and one digit').show();
            return false;
        }
        return true;
    }

    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password, password_regex);
    });

    /* client side validation for password which is entered again */
    var password_check = $('#password_check').val();
    $('.hide_password_check_details').hide();

    function passwordCheckValidate(password, password_check, password_regex) {
        if (true === passwordValidate(password, password_regex)) {
            if ('' === password_check) {
                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('Password is required').show();
                return false;
            } else if (password != password_check) {
                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('The two passwords do not match').show();
                return false;
            }
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

    /* checking the fields again upon submit */
    $('#submit').click(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        if(false === passwordValidate(password, password_regex) ||
            false === passwordCheckValidate(password, password_check, password_regex)
        ){
         return false;
        }
    });
});
