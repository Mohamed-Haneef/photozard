$.post('/api/posts/count', {
    id: 10
}, function(data) {
    console.log(data);
    $('#total-posts-count').html(data.count);
});