
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

function load_po_list() {
    $.ajax({
        url: 'inventory/load_po_list',
        type: 'GET',
        success: function(response) {
            $('#load_po_list').html(response);
        },
        error: function(xhr, status, error) {
            console.error("Error loading Purchase Order:", error);
        }
    });
}

$(document).ready(function () {
    load_inventory();
    load_po_list();
});


$('#stock_in').click(function () {
    $('#modal-stock-in').modal('show');
});

$('#stock_in_purchase').click(function () {
    $('#modal-stock-in-purchase').modal('show');
});

var approve_po = (btn) => {
    let po_number = btn.getAttribute('data-PO');

    $.confirm({
        title: 'Confirm Approval',
        content: 'Are you sure you want to approve this Purchase Order?',
        type: 'green',
        buttons: {
            confirm: {
                text: 'Yes, Approve',
                btnClass: 'btn-success',
                action: function () {
                    $.post({
                        url: 'inventory/service/Inventory_service/approve_po',
                        data: { po_number: po_number },
                        success: function (resp) {
                            let e;
                            try {
                                e = JSON.parse(resp);
                            } catch (err) {
                                toastr.error("Invalid response from server");
                                return;
                            }

                            if (!e.has_error) {
                                toastr.success(e.message);
                                // load_po_list();
                                // Optional reload
                                setTimeout(() => window.location.reload(), 500);
                            } else {
                                toastr.error(e.message);
                            }
                        },
                        error: function () {
                            toastr.error("An error occurred while approving the PO.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger',
                action: function () {}
            }
        }
    });
};

var del_po = (btn) => {
    let po_number = btn.getAttribute('data-PO');

    $.confirm({
        title: 'Confirm Deletion',
        content: 'Are you sure you want to delete this Purchase Order?',
        type: 'red',
        buttons: {
            confirm: {
                text: 'Yes, Delete',
                btnClass: 'btn-danger',
                action: function () {
                    $.post({
                        url: 'inventory/service/Inventory_service/delete_po',
                        data: { po_number: po_number },
                        success: function (resp) {
                            let e;
                            try {
                                e = JSON.parse(resp);
                            } catch (err) {
                                toastr.error("Invalid response from server");
                                return;
                            }

                            if (!e.has_error) {
                                toastr.success(e.message);
                                // load_po_list();
                                // Optional reload
                                setTimeout(() => window.location.reload(), 500);
                            } else {
                                toastr.error(e.message);
                            }
                        },
                        error: function () {
                            toastr.error("An error occurred while deleting the PO.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-secondary',
                action: function () {}
            }
        }
    });
}

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

var view_po = (btn) => {
    let po_num = $(btn).data("po");
    console.log("Viewing PO:", po_num);
    window.location = base_url + "inventory/Inventory/load_po/?pon=" + po_num;
}

var removeRow = (btn) => {
    let rowIndex = $(btn).closest("tr").index();
    let poItemId = $(btn).data("id");
    $(btn).closest("tr").remove();
    console.log("Removing PO item with ID:", poItemId);
    $.ajax({
        url: base_url + "inventory/service/Inventory_service/remove_po_item",
        type: "POST",
        data: { id: poItemId },
        success: function (response) {
            let res = JSON.parse(response);
            if (!res.has_error) {
                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        },
        error: function () {
            toastr.error("Error removing item.");
        }
    });
}


var edit_po = (btn) => {
    $('#edit-po-modal').modal('show');
    let poNumber = $(btn).data("po");  // ✔ use btn, not this
    console.log("Editing PO:", poNumber);
    $.ajax({
        url: base_url + "inventory/Inventory/get_po_details/?pon=" + poNumber,
        type: "GET",
        dataType: "json",
        success: function (data) {
            console.log("Response:", data);

            if (data && data.header) {
                let header = data.header;

                // Fill form fields
                $("#e-po_number").val(header.po_num);
                $("#e-date_in").val(header.date_ordered.split(" ")[0]);
                $("#e-supplier").val(header.supplier_ID);
                $("#e-recieved_by").val(header.received_by);

                // Clear current table
                $("#e-order_table tbody").empty();

                // Loop through items
                if (data.items && data.items.length > 0) {
                    data.items.forEach(function (row) {
                        let tr = `
                            <tr>
                                <td data-unit-id="${row.unit_ID}">${row.unit_of_measure ?? ''}</td>
                                <td>${row.qty ?? ''}</td>
                                <td data-item-id="${row.po_item_id}">${row.item_name ?? ''}</td>
                                <td>${row.unit_price ?? ''}</td>
                                <td>${row.description ?? ''}</td>
                                <td>${row.date_expiry ? row.date_expiry.split(" ")[0] : ''}</td>
                                <td>${row.threshold ?? ''}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger" onclick="removeRow(this)" data-id="${row.po_item_id}">Remove</button>
                                </td>
                            </tr>
                        `;
                        $("#e-order_table tbody").append(tr);
                    });
                }
            }
        }
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
    let date_expiry = $("#date_expiry").val();
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
        date_expiry,
        threshold
    };
    orderItems.push(newItem);

    let formattedExpiry = "";
    if (date_expiry instanceof Date) {
        formattedExpiry = date_expiry.toISOString().split('T')[0]; 
    } else {
        formattedExpiry = date_expiry; 
    }
    console.log(formattedExpiry);
    // Append to table
    let row = `
        <tr>
            <td>${unit_text}</td>
            <td>${qty}</td>
            <td>${item_text}</td>
            <td>${unit_price}</td>
            <td>${desc}</td>
            <td>${formattedExpiry}</td>
            <td>${threshold}</td>
            <td><button class="btn btn-danger btn-sm remove-item">Remove</button></td>
        </tr>`;
    $("#order_table tbody").append(row);

    // Clear fields after add
    $("#quantity").val("");
    $("#unit_price").val("");
    $("#item_desc").val("");
    // $("#threshold").val("");
    // $("#branded_flag").prop("checked", false);
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

// var del_po = (btn) => {
//     $.confirm({
//         title: 'Delete Purchase Order',
//         icon: 'fa fa-question-circle',
//         content: 'Delete Purchase Order? (Action Cannot Be Reversed)',
//         buttons: {
//             confirm: {
//                 text: 'Confirm',
//                 btnClass: 'btn-success',
//                 action: function () {
//                     $.post({
//                         url: 'inventory/service/Inventory_service/delete_po',
//                         data: {
//                             po_number: $('#po_number').val(),
//                             supplier: $('#supplier').val(),
//                             date_in: $('#date_in').val(),
//                             recieved_by: $('#recieved_by').val(),
//                             items: orderItems // <-- send array
//                         },
//                         success: function (e) {
//                             var e = JSON.parse(e);
//                             if (!e.has_error) {
//                                 toastr.success(e.message);

//                                 $('#modal-stock-in-purchase').modal('hide');
//                                 // load_inventory();

//                                 // reset everything
//                                 orderItems = [];
//                                 $("#order_table tbody").empty();
//                                 $('#po_number').val("");
//                                 $('#supplier').val("");
//                                 $('#date_in').val("");
//                             } else {
//                                 toastr.error(e.message);
//                             }
//                         },
//                         error: function () {
//                             toastr.error("Something went wrong.");
//                         }
//                     });
//                 }
//             },
//             cancel: {
//                 text: 'Cancel',
//                 btnClass: 'btn-danger',
//                 action: function () { }
//             }
//         }
//     });
// }

$("#update-po").on("click", function () {
    let poData = {
        po_number: $("#e-po_number").val(),
        date_in: $("#e-date_in").val(),
        supplier_id: $("#e-supplier").val(),
        received_by: $("#e-recieved_by").val(),
        items: []
    };

    $("#e-order_table tbody tr").each(function () {
        let row = $(this).find("td");
        let tds = $(this).find("td");
        let unitID = tds.eq(0).data("unit-id");    
        let itemID = tds.eq(2).data("item-id");     
        poData.items.push({
            unit_id: unitID,
            qty: $(row[1]).text(),
            item_id: itemID,
            unit_price: $(row[3]).text(),
            date_expiry: $(row[5]).text(),
            threshold: $(row[6]).text()
        });
    });

    console.log("Submitting edited PO:", poData);

    $.confirm({
        title: 'Confirm Update',
        content: 'Are you sure you want to update this purchase order?',
        type: 'blue',
        buttons: {
            confirm: {
                text: 'Confirm',
                btnClass: 'btn-success',
                action: function () {
                    $.ajax({
                        url: base_url + "inventory/service/Inventory_service/update_po",
                        type: "POST",
                        data: JSON.stringify(poData),
                        contentType: "application/json",
                        success: function (resp) {
                            alert("Purchase Order updated successfully!");
                            $('#edit-po-modal').modal('hide');
                        },
                        error: function () {
                            alert("Error saving changes.");
                        }
                    });
                }
            },
            cancel: {
                text: 'Cancel',
                btnClass: 'btn-danger',
                action: function () {
                    // Do nothing on cancel
                }
            }
        }
    });
});