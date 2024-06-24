$(document).ready(function() {
    $('#signup-form').on('submit', function(e) {
        e.preventDefault();
        // Get form data
        let signup_username = $('#username').val();
        let signup_email_address = $('#email_address').val();
        let signup_phone = $('#phone').val();
        let signup_date_of_birth = $('#date_of_birth').val();
        let signup_password = $('#password').val();

        // Validate form data
        if (!signup_username || !signup_email_address || !signup_phone || !signup_date_of_birth || !signup_password) {
            modalMessage('Missing fields', 'You need to fill all the given fields to Signup');
            return;
        }

        // Validate username length
        if (signup_username.length < 5) {
            modalMessage('Format error', 'Username must be at least 5 characters long.');
            return;
        }

        // Validate phone number using regex
        const phoneRegex = /^[0-9]{10}$/;
        if (!phoneRegex.test(signup_phone)) {
            modalMessage('Format error', 'Invalid phone number. It should be a 10-digit number without spaces or special characters.');
            return;
        }

        // Validate email address using regex
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(signup_email_address)) {
            modalMessage('Format error', 'Please enter a valid email address.');
            return;
        }

        var formData = {
            username: signup_username,
            email_address: signup_email_address,
            phone: signup_phone,
            date_of_birth: signup_date_of_birth,
            password: signup_password
        }
        // Send the form data using AJAX
        $.ajax({
            type: 'POST',
            url: "/api/auth/signup",
            data: formData,
            success: function(response) {
                var signupResponse = response.success
                if(signupResponse !== null){
                    alert('Signup success now you can login to continue..');
                    window.location.href = '/login?signup=true'
                }
            },
            error: function (errorRequest, error) {
                if (errorRequest.responseJSON !== undefined) {
                    var errorResponse = errorRequest.responseJSON.error
            
                    if (errorResponse) {
                        modalMessage("Error Signing up",  errorResponse)
                    } else {
                        modalMessage("Unable to signup", "Please wait for sometime and try again later");
                    }
                } else {
                    modalMessage("Unable to signup", "Please wait for sometime and try again later");
                }
            }
        });

    })
});