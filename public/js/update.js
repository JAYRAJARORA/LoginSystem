/* form validation using jquery */
$(document).ready(function () {
    /* client side validation for firstname */
    var alphabet_regex = /^[A-Za-z]+$/;
    $('.hide_firstname_details').hide();

    function firstnameValidate(firstname, alphabet_regex) {
        if ('' === firstname) {
            $('#firstname').parent().addClass('has-error');
            $('#firstname_check').html('Please enter your firstname').show();
            return false;
        } else if (!alphabet_regex.test(firstname)) {
            $('#firstname').parent().addClass('has-error');
            $('#firstname_check').html('Firstname can contain letters only').show();
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


    /* client side validation for lastname */
    $('.hide_lastname_details').hide();

    function lastnameValidate(lastname, alphabet_regex) {
        if ('' === lastname) {
            $('#lastname').parent().addClass('has-error');
            $('#lastname_check').html('Please enter your lastname').show();
            return false;
        } else if (!alphabet_regex.test(lastname)) {
            $('#lastname').parent().addClass('has-error');
            $('#lastname_check').html('Lastname can contain letters only').show();
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


    /* client side validation for email */
    var email_regex = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
    $('.hide_email_details').hide();

    function emailValidate(email, email_regex) {
        if ('' === email) {
            $('#email').parent().addClass('has-error');
            $('#email_check').html('Please enter your email').show();
            return false;
        } else if (!email_regex.test(email)) {
            $('#email').parent().addClass('has-error');
            $('#email_check').html('Invalid email format').show();
            return false;
        }
        return true;
    }

    $('#email').focus(function () {
        $('#email_check').hide();
        $('#email').parent().removeClass('has-error');
    });

    $('#email').blur(function () {
        var email = $('#email').val();

        if (true ===emailValidate(email, email_regex)) {
            console.log(email);
            $.ajax({
                type : 'POST',
                url :  '/../../app/checkEmail.php',
                data : {
                    email : email
                },
                success : function (response) {
                    console.log(response);
                    var jsonresponse = $.parseJSON(response);
                    if (jsonresponse !==null) {
                        if (jsonresponse.hasOwnProperty('error')) {
                            console.log(jsonresponse.error.email);
                            $('#email').parent().addClass('has-error');
                            $('#email_check').html(jsonresponse.error.email).show();
                        } else if (jsonresponse.hasOwnProperty('success')) {
                            console.log(jsonresponse.success);
                        }
                    }
                },
                error : function (response) {
                    console.log(response);
                }
            });
        }
    });


    /* client side validation for pincode */
    var pincode_regex = /^[0-9]+$/;

    $('.hide_pincode_details').hide();

    function pincodeValidate(pincode, pincode_regex) {
        if ('' === pincode) {
            $('#zip').parent().addClass('has-error');
            $('#pincode_check').html('Please enter the pincode').show();
            return false;
        } else if (!pincode_regex.test(pincode)) {
            $('#zip').parent().addClass('has-error');
            $('#pincode_check').html('Pincode can have digits only').show();
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

    /* client side validation for city */
    $('.hide_city_details').hide();

    function cityValidate(city, alphabet_regex) {
        if ('' === city) {
            $('#city').parent().addClass('has-error');
            $('#city_check').html('Please enter the city').show();
            return false;
        } else if (!alphabet_regex.test(city)) {
            $('#city').parent().addClass('has-error');
            $('#city_check').html('City can have letters only').show();
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

    /* client side validation for password */
    var password_regex = /^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/;
    $('.hide_password_details').hide();
    $('.hide_password_check_details').hide();

    function passwordValidate(password, password_regex) {
        if ('' !==password && !password_regex.test(password)) {
            $('#password').parent().addClass('has-error');
            $('#password_error').html('Password must be at least 8 characters and must contain ' +
                'at least one lower case letter, one upper case letter and one digit').show();
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


    /* client side validation for password again */
    function passwordCheckValidate(password, password_check, password_regex) {
        if ('' !== password) {
            if ('' === password_check) {

                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('Please enter your password again').show();
                return false;

            }  else if (password != password_check) {
                $('#password_check').parent().addClass('has-error');
                $('#password_check_error').html('The two passwords do not match').show();
                return false;
            }
        }
    }

    $('#password_check').focus(function () {
        $('#password_check_error').hide();
        if($('#password_check_error').parent().hasClass('has-error')) {
            $('#password_check_error').parent().removeClass('has-error');
        }
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
        var is_error = true;

        is_error = firstnameValidate(firstname, alphabet_regex);
        is_error = lastnameValidate(lastname, alphabet_regex);
        is_error = emailValidate(email, email_regex);
        is_error = pincodeValidate(pincode, pincode_regex);
        is_error = cityValidate(city, alphabet_regex) ;
        is_error = passwordValidate(password, password_regex);
        is_error = passwordCheckValidate(password, password_check, password_regex);
        if (true === $('#email_check').is(':visible')) {
            is_error = false;
        }
        if (false === is_error) {
            return false;
        }

    });
});

