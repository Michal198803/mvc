$.validator.addMethod('validPassword',
    function (value, element, param) {

        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Must contain at least one letter and one number'
);

$(document).ready(function () {

    /**
     * Validate the form
     */
    $('#formSignup').validate({
        rules: {
            name: 'required',
            email: {
                required: true,
                email: true,
                remote: '/account/validate-email'
            },
            password: {
                required: true,
                minlength: 6,
                validPassword: true
            }
        },
        messages: {
            email: {
                remote: 'email already taken'
            }
        }
    });


    /**
     * Show password toggle button
     */
    $('#inputPassword').hideShowPassword({
        show: false,
        innerToggle: 'focus'
    });
});