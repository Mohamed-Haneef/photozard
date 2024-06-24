
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
