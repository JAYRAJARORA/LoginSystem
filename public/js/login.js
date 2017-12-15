$(document).ready(function () {
    // success and error message for forgot password modal form
    $('.success_box').hide();
    $('.hide_error').hide();

    // upon submit check for email else do the ajax request
    /*ajax request sends the email entered and in response
    gives the error or success message as json
     */
    $('#forgot_pass_submit').click(function () {
        var modal_email = $('#modal_email').val();
        if (modal_email == '') {
            $("#display_errors").parent().addClass('has-error');
            $('#display_errors').html("Email is required");
            $('#display_errors').show();
        }
        else {
            $.ajax({
                type: "POST",
                url: "/../../app/forgotPassword.php",
                data: {
                    email: modal_email
                },
                success: function (response) {
                    console.log(response);
                    var jsonresponse = $.parseJSON(response);
                    console.log(jsonresponse);
                    if (jsonresponse.hasOwnProperty('error')) {
                        $("#display_errors").parent().addClass('has-error');
                        $('#display_errors').html(jsonresponse.error);
                        $('#display_errors').show();
                    } else if (jsonresponse.hasOwnProperty('success')) {
                        $('#successMessage').html(jsonresponse.success);
                        $('.success_box').show();
                    }

                },
                error: function (response) {
                }
            });
        }
        $('#modal_email').focus(function () {
            $('.hide_error').hide();
        });

    });

    // client side validation for username
    $('.hide_username_details').hide();
    var user_regex = /^[0-9a-zA-Z_]{3,}$/;

    function usernameValidate(username, user_regex, error) {
        if ('' === username) {
            $("#username").parent().addClass('has-error');
            $('#username_check').html("Please enter your username");
            $('#username_check').show();
            error.foo = 1;
        } else if (!user_regex.test(username)) {
            $("#username").parent().addClass('has-error');
            $('#username_check').html("Username has to be bigger than 3 chars and contain only " +
                "digits, letters and underscore");
            $('#username_check').show();
            error.foo = 1;
        }
    }

    // hide event on focus and call the validate function on blur
    $('#username').focus(function () {
        $('#username_check').hide();
        $('#username_check').parent().removeClass('has-error');
    });
    $('#username').blur(function () {
        var username = $('#username').val();
        usernameValidate(username, user_regex);
    });


    // client side validation for username
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();

    function passwordValidate(password, password_regex, error) {
        if ('' === password) {
            $("#password").parent().addClass('has-error');
            $('#password_error').html("Please enter your password");
            $('#password_error').show();
            if (typeof(error) != "undefined") {
                error.foo = 1;
            }
        } else if (!password_regex.test(password)) {
            $("#password").parent().addClass('has-error');
            $('#password_error').html("Password has to be at least 8 characters and must contain " +
                "at least one lower case letter, one upper case letter and one digit");
            $('#password_error').show();
            if (typeof(error) != "undefined") {
                error.foo = 1;
            }
        }
    }

    // hide event on focus and call the validate function on blur
    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password_error').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password, password_regex);
    });

    // checking the details again if the fields are invalid do not submit the form
    $('#submit').click(function () {
        var username = $('#username').val();
        var password = $('#password').val();
        var error = {"foo": 0};
        usernameValidate(username, user_regex, error);
        passwordValidate(password, password_regex, error);
        if (error.foo == 1) {
            return false;
        }
    });
});