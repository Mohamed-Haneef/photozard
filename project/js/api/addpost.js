
$('#share-memory').on('click', function(){
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
            url: '/api/posts/add', // Replace with your server endpoint
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

            },
            error: function(error) {
                console.error('Error uploading file');
                console.log(error);
            }
        });
    } else {
        t = new Toast('Error', 'now', 'Please select a file to upload');
        t.show();
    }
});