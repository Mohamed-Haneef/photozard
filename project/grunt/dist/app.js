/*Processed by SNA Labs on 25/6/2024 @ 17:17:59*/

$('#share-memory').on('click', function(){
    var $this = $(this);
    $this.prop('disabled', true);
    var formData = new FormData();
    var files = $('#post_image')[0].files;
    if ($('#post_text').val() == "") {
        t = new Toast('Error', 'now', 'Please enter a caption');
        t.show();
        return;
    }
    if (files.length > 0) {
        formData.append('post_image', files[0]);
        formData.append('post_text', $('#post_text').val());

        $.ajax({
            url: '/api/posts/add', 
            type: 'POST',
            data: formData,
            contentType: false, // Important: Set content type to false
            processData: false, // Important: Do not process the data
            success: function(response) {
                console.log('File uploaded successfully');
                console.log(response);
                response = $(response);
                $grid.prepend(response).masonry('prepended', response).masonry('layout');
                $grid.imagesLoaded().progress( function() {
                    $grid.masonry('layout');
                });
                $('#post_image').val("");
                $('#post_text').val("");
                let postCount = parseInt($('#total-posts-count').text());
                postCount += 1;
                $('#total-posts-count').html(postCount)
                $this.prop('disabled', false);

            },
            error: function(error) {
                console.error('Error uploading file');
                console.log(error);
                $this.prop('disabled', false);
                modalMessage("Error occured", "Unable to upload image!")
            }
        });
    } else {
        t = new Toast('Error', 'now', 'Please select a file to upload');
        t.show();
    }
});
$.post('/api/posts/count', {
    id: 10
}, function(data) {
    console.log(data);
    $('#total-posts-count').html(data.count);
});

$(document).on('click', '.album .btn-delete', function(){
    post_id = $(this).parent().attr('data-id');
    d = new Dialog("Delete Post", "Are you sure want to remove this post");
    d.setButtons([
        {
            'name': "Delete",
            "class": "btn-danger",
            "onClick": function(event){
                $.post('/api/posts/delete',
                {
                    id: post_id
                }, function(data, textSuccess, xhr){
                    console.log(textSuccess);
                    console.log(data);

                    if(textSuccess =="success" ){ 
                        var el = $(`#post-${post_id}`)[0]
                        $grid.masonry('remove', el).masonry('layout');
                        let postCount = parseInt($('#total-posts-count').text());
                        postCount -= 1;
                        $('#total-posts-count').html(postCount)
                    }
                });

                $(event.data.modal).modal('hide')
            }
        },
        {
            'name': "Cancel",
            "class": "btn-secondary",
            "onClick": function(event){
                $(event.data.modal).modal('hide');
            }
        }
    ]);
    d.show();
});

$(document).on('click', '.album .btn-like', function() {
    var post_id = $(this).parent().attr('data-id');
    var $this = $(this);

    formData = {
        id: post_id
    }
    $.ajax({
        type: 'POST',
        url: "/api/posts/like",
        data: formData,
        success: function(response) {
            var likeResponse = response.success
            if(likeResponse !== null){
                var totalLikesElement = $this.closest('.card-body').find('#total-like-count');
                var totalLikes = parseInt(totalLikesElement.html());
                if(likeResponse == true){
                    $this.html("Liked");
                    $this.removeClass('btn-outline-primary').addClass('btn-primary');
                    $this.blur()
                    totalLikes += 1
                    console.log("total like: " + totalLikes)
                    console.log("total like: " + totalLikesElement)
                    totalLikesElement.html(totalLikes);
                }else if(likeResponse == false){
                    $this.html("Like");
                    $this.removeClass('btn-primary').addClass('btn-outline-primary');
                    $this.blur()
                    console.log("total like(bfr): " + totalLikes)
                    totalLikes -= 1
                    console.log("total like(aftr): " + totalLikes)
                    totalLikesElement.html(totalLikes);
                }else{
                    alert("Unable to process the like. Please try again")
                }
                
                
            }else{
                alert("Some error while liking")
            }
        },
        error: function (errorRequest, error) {
            if (errorRequest.responseJSON !== undefined) {
                var errorResponse = errorRequest.responseJSON.error
        
                if (errorResponse) {
                    alert("Error: " + errorResponse)
                } else {
                    alert("Error response not found" + JSON.stringify(errorRequest.responseJSON));
                }
            } else {
                alert(errorRequest.responseJSON);
            }
        }
    });

});
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
// init Masonry
let $grid = $('#masonry-area').masonry({
    // itemSelector: '.col',
    // columnWidth: '.col',
    percentPosition: true
});
// layout Masonry after each image loads
$grid.imagesLoaded().progress( function() {
    $grid.masonry('layout');
});

function setCookie(name, value, daysToExpire) {
    var expires = "";
    
    if (daysToExpire) {
      var date = new Date();
      date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));
      expires = "; expires=" + date.toUTCString();
    }
  
    document.cookie = name + "=" + value + expires + "; path=/";
  }
  
  
//# sourceMappingURL=app.js.map