// alert();
var load_suppliers = () => {
    $(document).gmLoadPage({
        url: 'item_profiling/load_item_profiles',
        load_on: '#load_item_profiles'
    });
}

$(document).ready(function () {
    load_suppliers();
});

var editProfile = (data) => {
    // console.log(data.getAttribute('data-item_id'));

    $('#item_profile_id').val(data.getAttribute('data-id'));

    $('#item_id').val(data.getAttribute('data-item_id'));
    $('#unit_id').val(data.getAttribute('data-unit_id'));
    $('#unit_price').val(data.getAttribute('data-unit_price'));
    $('#threshold').val(data.getAttribute('data-threshold'));
  
    $('#save_item_profile').hide();
    $('#update_item_profile').show();
  }

$('#save_item_profile').click(function () {
    // alert($('#unit_id').val());
    $.confirm({
        title: 'Confirmation',
        icon: 'fa fa-question-circle',
        content: 'Are you sure you want to save item profile details?',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.post({
                        url: 'item_profiling/service/Item_profiling_service/save_item_profile',
                        // selector: '.form-control',
                        data: {
                            item_id: $('#item_id').val(),
                            unit_id: $('#unit_id').val(),
                            unit_price: $('#unit_price').val(),
                            threshold: $('#threshold').val(),
                        },
                        success: function (e) {
                            var e = JSON.parse(e);
                            if (e.has_error == false) {
                                toastr.success(e.message);
                                load_suppliers();

                                  $('#item_id').val("1");
                                  $('#unit_id').val("1");
                                  $('#unit_price').val("");
                                  $('#threshold').val("");

                                //   setTimeout(function () {
                                //     window.location.reload();
                                //   }, 500);
                            } else {
                                $('#List').attr('class', 'form-control inpt is-invalid');
                                toastr.error(e.message);
                            }
                        },
                    })
                },
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger',
                action: function () {
                },
            },
        },
    });
});


$('#update_item_profile').click(function () {
    // alert($('#item_profile_id').val());
    // return;

    $.confirm({
        title: 'Confirmation',
        icon: 'fa fa-question-circle',
        content: 'Are you sure you want to save item profile details?',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.post({
                        url: 'item_profiling/service/Item_profiling_service/update_item_profile',
                        // selector: '.form-control',
                        data: {
                            id: $('#item_profile_id').val(),

                            item_id: $('#item_id').val(),
                            unit_id: $('#unit_id').val(),
                            unit_price: $('#unit_price').val(),
                            threshold: $('#threshold').val(),
                        },
                        success: function (e) {
                            var e = JSON.parse(e);
                            if (e.has_error == false) {
                                toastr.success(e.message);
                                load_suppliers();

                                  $('#item_id').val("1");
                                  $('#unit_id').val("1");
                                  $('#unit_price').val("");
                                  $('#threshold').val("");

                                //   setTimeout(function () {
                                //     window.location.reload();
                                //   }, 500);
                            } else {
                                $('#List').attr('class', 'form-control inpt is-invalid');
                                toastr.error(e.message);
                            }
                        },
                    })
                },
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger',
                action: function () {
                },
            },
        },
    });
});