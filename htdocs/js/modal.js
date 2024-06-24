function modalMessage(header, message){
    $('#notification-modal-overlay').show();
    $('#modal-header').html(header)
    $('#modal-message').html(message)
}
$('#notification-modal-overlay').click(function (event) {
    if ($(event.target).is('#notification-modal-overlay')) {
        $('#notification-modal-overlay').hide();
    }
});
$('#close-modal').click(function () {
    $('#notification-modal-overlay').hide();
});



