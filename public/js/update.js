// form validation using jquery
$(document).ready(function () {
    // client side validation for firstname
    var alphabet_regex = /^[A-Za-z]+$/;
    $('.hide_firstname_details').hide();

    function firstnameValidate(firstname, alphabet_regex) {
        if ('' === firstname) {
            $("#firstname").parent().addClass('has-error');
            $('#firstname_check').html("Please enter your firstname");
            $('#firstname_check').show();
            return false;
        } else if (!alphabet_regex.test(firstname)) {
            $("#firstname").parent().addClass('has-error');
            $('#firstname_check').html("Firstname can contain letters only");
            $('#firstname_check').show();
            return false;
        }
    }

    $('#firstname').focus(function () {
        $('#firstname_check').hide();
        $('#firstname').parent().removeClass('has-error');
    });
    $('#firstname').blur(function () {
        var firstname = $('#firstname').val();
        firstnameValidate(firstname, alphabet_regex);
    });


    // client side validation for lastname
    $('.hide_lastname_details').hide();

    function lastnameValidate(lastname, alphabet_regex) {
        if ('' === lastname) {
            $("#lastname").parent().addClass('has-error');
            $('#lastname_check').html("Please enter your lastname");
            $('#lastname_check').show();
            return false;
        } else if (!alphabet_regex.test(lastname)) {
            $("#lastname").parent().addClass('has-error');
            $('#lastname_check').html("Lastname can contain letters only");
            $('#lastname_check').show();
            return false;
        }
    }

    $('#lastname').focus(function () {
        $('#lastname_check').hide();
        $('#lastname').parent().removeClass('has-error');
    });
    $('#lastname').blur(function () {
        var lastname = $('#firstname').val();
        lastnameValidate(lastname, alphabet_regex);
    });


    // client side validation for email
    var email_regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    $('.hide_email_details').hide();

    function emailValidate(email, email_regex) {
        if ('' === email) {
            $("#email").parent().addClass('has-error');
            $('#email_check').html("Please enter your email");
            $('#email_check').show();
            return false;
        } else if (!email_regex.test(email)) {
            $("#email").parent().addClass('has-error');
            $('#email_check').html("Invalid email format");
            $('#email_check').show();
            return false;
        }
    }

    $('#email').focus(function () {
        $('#email_check').hide();
        $('#email').parent().removeClass('has-error');
    });
    $('#email').blur(function () {
        var email = $('#email').val();
        emailValidate(email, email_regex)
    });


    // client side validation for pincode
    var pincode_regex = /^[0-9]+$/;

    $('.hide_pincode_details').hide();

    function pincodeValidate(pincode, pincode_regex) {
        if ('' === pincode) {
            $("#zip").parent().addClass('has-error');
            $('#pincode_check').html("Please enter the pincode");
            $('#pincode_check').show();
            return false;
        } else if (!pincode_regex.test(pincode)) {
            $("#zip").parent().addClass('has-error');
            $('#pincode_check').html("Pincode can have digits only");
            $('#pincode_check').show();
            return false;
        }
    }

    $('#zip').focus(function () {
        $('#pincode_check').hide();
        $('#zip').parent().removeClass('has-error');
    });
    $('#zip').blur(function () {
        var pincode = $('#zip').val();
        pincodeValidate(pincode, pincode_regex);
    });

    // client side validation for city
    $('.hide_city_details').hide();

    function cityValidate(city, alphabet_regex) {
        if ('' === city) {
            $("#city").parent().addClass('has-error');
            $('#city_check').html("Please enter the city");
            $('#city_check').show();
            return false;
        } else if (!alphabet_regex.test(city)) {
            $("#city").parent().addClass('has-error');
            $('#city_check').html("City can have letters only");
            $('#city_check').show();
            return false;
        }
    }

    $('#city').focus(function () {
        $('#city_check').hide();
        $('#city').parent().removeClass('has-error');
    });
    $('#city').blur(function () {
        var city = $('#city').val();
        cityValidate(city, alphabet_regex);
    })

    // client side validation for password
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();
    $('.hide_password_check_details').hide();

    function passwordValidate(password, password_regex) {
        if ('' === password) {
            $("#password").parent().addClass('has-error');
            $('#password_error').html("Please enter your password");
            $('#password_error').show();
            return false;

        } else if (!password_regex.test(password)) {
            $("#password").parent().addClass('has-error');
            $('#password_error').html("Password must be at least 8 characters and must contain " +
                "at least one lower case letter, one upper case letter and one digit");
            $('#password_error').show();
            return false;

        }
    }

    $('#password').focus(function () {
        $('#password_error').hide();
        $('#password_error').parent().removeClass('has-error');
    });
    $('#password').blur(function () {
        var password = $('#password').val();
        passwordValidate(password, password_regex);
    });


    // client side validation for password again
    var password_check = $('#password_check').val();

    function passwordCheckValidate(password, password_check, password_regex) {
        if ('' === password_check) {

            $("#password_check").parent().addClass('has-error');
            $('#password_check_error').html("Please enter your password again");
            $('#password_check_error').show();
            return false;

        } else if (!password_regex.test(password_check)) {
            $("#password_check").parent().addClass('has-error');
            $('#password_check_error').html("Password must be at least 8 characters and must contain " +
                "at least one lower case letter, one upper case letter and one digit");
            $('#password_check_error').show();
            return false;

        } else if (password != password_check) {
            $("#password_check").parent().addClass('has-error');
            $('#password_check_error').html("The two passwords do not match");
            $('#password_check_error').show();
            return false;

        }
    }

    $('#password_check').focus(function () {
        $('#password_check_error').hide();
        $('#password_check_error').parent().removeClass('has-error');
    });
    $('#password_check').blur(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        passwordCheckValidate(password, password_check, password_regex);
    });

    $('#submit').click(function () {
        var password = $('#password').val();
        var password_check = $('#password_check').val();
        var firstname = $('#firstname').val();
        var lastname = $('#lastname').val();
        var email = $('#email').val();
        var pincode = $('#zip').val();
        var city = $('#city').val();

        if (false === firstnameValidate(firstname, alphabet_regex) ||
            false === lastnameValidate(lastname, alphabet_regex) ||
            false === emailValidate(email, email_regex) ||
            false === pincodeValidate(pincode, pincode_regex) ||
            false === cityValidate(city, alphabet_regex) ||
            false === passwordValidate(password, password_regex) ||
            false === passwordCheckValidate(password, password_check, password_regex)
        ){
            return false;
        }

    });
});

