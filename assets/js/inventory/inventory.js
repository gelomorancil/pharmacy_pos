
// alert();

function load_inventory() {
    $.ajax({
        url: 'inventory/load_inventory',
        type: 'GET',
        success: function(response) {
            $('#load_inventory').html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error loading inventory:", error);
        }
    });
}

$(document).ready(function () {
    load_inventory();
});


$('#stock_in').click(function () {
    $('#modal-stock-in').modal('show');
});

var view_history = (value) => {
    // alert(data.getAttribute('data-itemID'));
    $.post({
        url: 'inventory/Inventory/load_history',
        data: {
            id: value.getAttribute('data-itemID'),
        },
        success: function (data) {

            // console.log(data)
            $('#load_history_data').html(data);
            $('#modal-stock-history').modal('show');

            // load_inventory();

            // $('#item').val("");
            // $('#quantity').val("");
            // $('#date_in').val("");

            // setTimeout(function () {
            //     window.location.reload();
            // }, 500);
        },
    });
}



$('#add_stock').click(function () {
    $.confirm({
        title: 'Confirmation',
        icon: 'fa fa-question-circle',
        content: 'Confirm Stock-In? (Action Cannot Be Reversed)',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.post({
                        url: 'inventory/service/Inventory_service/save_stock_in',
                        data: {
                            item: $('#item').val(),
                            supplier: $('#supplier').val(),
                            quantity: $('#quantity').val(),
                            date_in: $('#date_in').val(),
                            recieved_by: $('#recieved_by').val(),
                        },
                        success: function (e) {
                            var e = JSON.parse(e);
                            if (!e.has_error) {
                                toastr.success(e.message);

                                $('#modal-stock-in').modal('hide');

                                load_inventory();

                                $('#item').val("");
                                $('#quantity').val("");
                                $('#date_in').val("");

                                // setTimeout(function () {
                                //     window.location.reload();
                                // }, 500);
                            } else {
                                toastr.error(e.message);
                            }
                        },
                    });
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



