$(document).ready(function () {
    $('#change').on('click', function () {
        $.ajax({
            url: base_url + 'login/service/login_service/refresh_session',
            type: "POST",
            dataType: "JSON",
            data: {
                Branch: $(this).val(),
            },
            // error: function() {
            //     if(confirm("Session refresh failed.  Your session will timeout if you do not refresh the page or navigate to another location. Click OK to refresh this page or cancel to return to this page."))
            //         location.reload(true);
            // },
            // success: function(jsondata, status, xhr){
            //     initTimers();
            // }
        });
    });
});