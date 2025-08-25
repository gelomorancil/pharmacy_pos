
// alert();
var orderItems = [];

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

$('#stock_in_purchase').click(function () {
    $('#modal-stock-in-purchase').modal('show');
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
                            po_number: $('#po_number').val(),
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



$("#add_to_table").on("click", function () {
    let unit_id = $("#unit_id").val();
    let unit_text = $("#unit_id option:selected").text();
    let qty = $("#quantity_po").val();
    let item_id = $("#item").val();
    let item_text = $("#item option:selected").text();
    let unit_price = $("#unit_price").val();
    let desc = $("#item_desc").val();
    let branded = $("#branded_flag").is(":checked") ? "Yes" : "No";
    let threshold = $("#threshold").val();

    console.log(qty, item_id, unit_price);
    if (!qty || !item_id || !unit_price) {
        alert("Quantity, Item, and Unit Price are required!");
        return;
    }

    // Store to array
    let newItem = {
        unit_id,
        unit_text,
        qty,
        item_id,
        item_text,
        unit_price,
        desc,
        branded,
        threshold
    };
    orderItems.push(newItem);

    // Append to table
    let row = `
        <tr>
            <td>${unit_text}</td>
            <td>${qty}</td>
            <td>${item_text}</td>
            <td>${unit_price}</td>
            <td>${desc}</td>
            <td>${branded}</td>
            <td>${threshold}</td>
            <td><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
        </tr>`;
    $("#order_table tbody").append(row);

    // Clear fields after add
    $("#quantity").val("");
    $("#unit_price").val("");
    $("#item_desc").val("");
    $("#threshold").val("");
    $("#branded_flag").prop("checked", false);
});

// Remove row
$(document).on("click", ".remove-item", function () {
    let rowIndex = $(this).closest("tr").index();
    orderItems.splice(rowIndex, 1); // remove from array
    $(this).closest("tr").remove();
});


$('#add_stock_po').click(function () {
    if (orderItems.length === 0) {
        toastr.error("Please add at least one item before confirming.");
        return;
    }

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
                        url: 'inventory/service/Inventory_service/save_stock_in_po',
                        data: {
                            po_number: $('#po_number').val(),
                            supplier: $('#supplier').val(),
                            date_in: $('#date_in').val(),
                            recieved_by: $('#recieved_by').val(),
                            items: orderItems // <-- send array
                        },
                        success: function (e) {
                            var e = JSON.parse(e);
                            if (!e.has_error) {
                                toastr.success(e.message);

                                $('#modal-stock-in-purchase').modal('hide');
                                load_inventory();

                                // reset everything
                                orderItems = [];
                                $("#order_table tbody").empty();
                                $('#po_number').val("");
                                $('#supplier').val("");
                                $('#date_in').val("");
                            } else {
                                toastr.error(e.message);
                            }
                        },
                        error: function () {
                            toastr.error("Something went wrong.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger',
                action: function () { }
            }
        }
    });
});