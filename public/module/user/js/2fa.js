$('.btn-disable-2fa').click(function (){
    $.ajax({
        method:'delete',
        url:bookingCore.url+'/user/two-factor-authentication',
        dataType:'json',
        success:function (res){
            window.location.reload();
        },
        error:function (e){
            if(e.status == 423){
                $('#confirm_password').modal('show')
            }
        }
    })
});
$('.bc-form-confirm-password').on('submit',function (event){
    event.preventDefault();
    var form = $(this);
    $.ajax({
        url: bookingCore.url + '/user/confirm-password',
        data: form.serialize(),
        method: 'POST',
        beforeSend: function () {
            form.find('.error').hide();
            form.find('.icon-loading').css("display", 'inline-block');
        },
        dataType:'json',
        success: function (data) {
            form.find('.icon-loading').hide();
            window.location.reload();
        },
        error:function (e){
            console.log(e)
            form.find('.icon-loading').hide();
            if(e.responseJSON && typeof e.responseJSON.message != 'undefined'){
                form.find('.message-error').show().html('<div class="alert alert-danger">' + e.responseJSON.message + '</div>');
            }
        }
    });
})
