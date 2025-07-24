
function checkPassword(password) {
    const minLength = 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /\d/.test(password);
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>_\-+=\[\]\\\/]/.test(password);

    if (password.length < minLength) {
        toastr.error("Password must be at least 8 characters long.");
        return false;
    }

    if (!hasUpperCase) {
        toastr.error("Password must contain at least one uppercase letter.");
        return false;
    }

    if (!hasLowerCase) {
        toastr.error("Password must contain at least one lowercase letter.");
        return false;
    }

    if (!hasNumber) {
        toastr.error("Password must contain at least one number.");
        return false;
    }

    if (!hasSpecialChar) {
        toastr.error("Password must contain at least one special character.");
        return false;
    }

    return true;
}

$('#change_password').on('click', function () {
    if (checkPassword($('#new_pass').val())) {
        $.ajax({
            url: base_url + 'change_password/service/change_password_service/change_password',
            type: "POST",
            dataType: "JSON",
            data: {
                username: $('#username').val(),
                current_pass: $('#current_pass').val(),
                new_pass: $('#new_pass').val(),
            },
            success: function (response) {
                if (response.has_error == true) {
                    toastr.error(response.message);
                } else {
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location = base_url + "dashboard";
                    }, 3000);
                }
            }
        });
    }
});