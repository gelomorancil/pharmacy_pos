$(document).ready(function () {
    $('#Login').on('click', function () {
        $.ajax({
            url: base_url + 'login/service/login_service/login',
            type: "POST",
            dataType: "JSON",
            data: {
                username: $('#username').val(),
                password: $('#password').val(),
            },
            success: function (response) {
                if (response.has_error) {
                    toastr.error(response.error_message);
                } else {
                    if (response.password_status == "0") {
                        window.location = base_url + "change_password";
                    }
                    else {
                        console.log(response.session.Role_ID);
                        if (response.session.Role_ID == 1) {
                            window.location = base_url + "dashboard";
                        }
                        else if(response.session.Role_ID == 2){
                            window.location = base_url + "cashiering";
                        }
                        else if(response.session.Role_ID == 3){
                            window.location = base_url + "dashboard";
                        }
                    }
                }
            }
        });
        // window.location = base_url + "dashboard";
    });

    $('#password').on('keyup', function (e) {
        if (e.keyCode == 13)
            $('#Login').click();
    });
});