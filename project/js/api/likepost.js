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