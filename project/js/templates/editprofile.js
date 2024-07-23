if (window.location.pathname == '/profile') {
    function previewPhoto(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('profile-photo-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    async function delete_current_profile(current_image) {
        try {
            const response = await fetch(`/api/profile/deleteprofile?profile=${encodeURIComponent(current_image)}`, {
                method: 'DELETE',
            });

            const result = await response.json();

            if (response.ok) {
                alert("Successfully deleted");
                return result;
            } else {
                let errorMessage = 'Unknown error occurred';
                if (result.error) {
                    try {
                        const parsedError = JSON.parse(result.error);
                        errorMessage = parsedError.message || 'Unknown error occurred';
                    } catch {
                        errorMessage = result.error;
                    }
                }
                alert("Error: " + errorMessage);
                return { status: 'error', message: errorMessage };
            }
        } catch (error) {
            alert('Failed to delete profile image: ' + error.message);
            return { status: 'error', message: error.message };
        }
    }


    $('#edit-profile').on('submit', function (event) {
        event.preventDefault();
        var formData = new FormData();
        var files = $('#profile-photo')[0].files;


        console.log("image value: " + files[0]);

        // if (files.length <= 0) {
        //     alert("upload an Image for profile to update")
        //     return;
        // }
        const photoRoute = $("#profile-photo-preview").attr('data')
        console.log("Photoroute: " + photoRoute);
        if (photoRoute !== '/profileimg/default.jpeg' && files.length <= 0) {
            formData.append('user_profile', photoRoute);
        } else {
            formData.append('user_profile', files[0]);
        }
        formData.append('username', $('#edit-username').val());
        formData.append('date_of_birth', $('#edit-date_of_birth').val());
        formData.append('bio', $('#edit-bio').val());
        formData.append('instagram', $('#edit-instagram').val());
        formData.append('twitter', $('#edit-twitter').val());
        formData.append('facebook', $('#edit-facebook').val());

        $.ajax({
            url: '/api/profile/updateprofile',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: async function (response) {
                var updateResponse = response.success
                if (updateResponse !== null) {
                    alert(updateResponse + ": profile updated");
                    const newpath = response.path;
                    const photopath = $("#profile-photo-preview").attr('data');
                    const currentphoto = $("#profile-photo-preview").attr('src')
                    $("#profile-photo-preview").attr('data', newpath)
                    console.log("Photo path: " + photopath)
                    console.log("new path: " + newpath)
                    if (newpath !== "/profileimg/default.jpeg" && photopath !== "/profileimg/default.jpeg" && files[0] == undefined) {
                        console.log("Delete condition true")
                        await delete_current_profile(photopath);
                        console.log("Deleted")
                    }
                }
            },
            error: function (errorRequest, error) {
                if (errorRequest.responseJSON !== undefined) {
                    var errorResponse = errorRequest.responseJSON.error

                    if (errorResponse) {
                        alert("Error: " + errorResponse)
                        modalMessage("Error", errorResponse)

                    } else {
                        modalMessage("error response not found", JSON.stringify(errorRequest.responseJSON));
                    }
                } else {
                    modalMessage("Internal error", errorRequest.responseJSON);
                }
            }
        });
    });
}

