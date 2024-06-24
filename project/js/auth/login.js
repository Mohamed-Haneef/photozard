$(document).ready(function() {
    $('#login-form').on('submit', function(e) {
        e.preventDefault();
        // Get form data
        let login_username = $('#user').val();
        let login_password = $('#password').val();

        // Validate form data
        if (!login_username|| !login_password) {
            modalMessage('Missing fields', 'You need to fill both the fields to login');
            return;
        }

        // Validate username length
        if (login_username.length < 5) {
            modalMessage('Format error', 'Username must be at least 5 characters long.');
            return;
        }

        var formData = {
            username: login_username,
            password: login_password
        }
        $.ajax({
            type: 'POST',
            url: "/api/auth/login",
            data: formData,
            success: function(response) {
                var signupResponse = response.success
                if(signupResponse !== null){
                    alert("Login success, you will be redirected")
                    window.location.href = '/';
                }
            },
            error: function (errorRequest, error) {
                if (errorRequest.responseJSON !== undefined) {
                    var errorResponse = errorRequest.responseJSON.error
            
                    if (errorResponse) {
                        // alert("Error: " + errorResponse)
                        modalMessage("Error", errorResponse)
                        
                    } else {
                        modalMessage("error response not found",  JSON.stringify(errorRequest.responseJSON));
                    }
                } else {
                    modalMessage("Internal error", errorRequest.responseJSON);
                }
            }
        });

    })
});