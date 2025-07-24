$(document).ready(function () {
    $('#Login').css('display','none');
    $('#Cancel').css('display','none');
    $('#Change').css('display','none');
});

$(document).on('click', '#reset_password', function () {
    $('#c_pass').css('display','block');
    $('#Login').css('display','block');
    $('#Cancel').css('display','block');
    $(this).css('display','none');

}); 

$(document).on('click', '#Cancel', function () {
    $('#c_pass').css('display','none');
    $('#Login').css('display','none');
    $('#reset_password').css('display','block');
    $(this).css('display','none');

}); 

// LOGIN OLD PASSWORD
$(document).on('click', '#Login', function () {
    $.post({
        url: base_url + 'user_profile/service/User_profile_service/authenticate_user',
        // selector: '.form-control',
        data: {
            pass     : $('#pass').val(),
            uname     : $('#uname').val()
        },
        success:function(e)
            {
                var e = JSON.parse(e);
                if(e.has_error == false){
                    $('#c_pass').css('display','none');
                    $('.n_pass').css('display','block');
                    
                    $('#Login').css('display','none');
                    $('#Cancel').css('display','none');
                    $('#Change').css('display','block');
                    toastr.success(e.error_message);

                } else {
                    toastr.error(e.error_message); 
                }
        },
    })

}); 

// CHANGE PASSWORD
$(document).on('click', '#Change', function () {
    var n = $('#new_pass').val();
    var r = $('#r_new_pass').val();

    if(n != r){
        toastr.warning("Entered password does not match! Try again");
        $('#new_pass').attr('class', 'form-control inpt is-invalid');
        $('#r_new_pass').attr('class', 'form-control inpt is-invalid');
        return;
    } else {
        $.post({
            url: base_url + 'user_profile/service/User_profile_service/change_pass',
            // selector: '.form-control',
            data: {
                uname     : $('#uname').val(),
                new : n,
                r_new : r
            },
            success:function(e)
                {
                    var e = JSON.parse(e);
                    if(e.has_error == false){
                        toastr.success(e.message);
                        setTimeout(function(){
                            window.location.reload();
                        },1000); 

                    } else {
                        toastr.error(e.message); 
                    }
            },
        })
    }

}); 

