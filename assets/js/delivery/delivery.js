function load_po_list() {
    $.ajax({
        url: 'delivery/load_po_list',
        type: 'GET',
        success: function (response) {
            $('#load_po_list').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading Purchase Order:", error);
        }
    });
}

$(document).ready(function () {
    load_po_list();
});

$('#stock_in').click(function () {
    $('#modal-stock-in').modal('show');
});

$('#stock_in_purchase').click(function () {
    $('#modal-stock-in-purchase').modal('show');
});

// var view_po = (btn) => {
//     let po_num = $(btn).data("po");
//     console.log("Viewing PO:", po_num);
//     window.location = base_url + "inventory/Inventory/load_po/?pon=" + po_num;
// }

// Auto-compute Unit Prices based on Freight Price
// Auto-compute Unit Prices based on Freight Price
$(document).on("keyup", "#e-freight", function () {

    let freightAmount = parseFloat($(this).val()) || 0;

    // count total PO items (number of rows)
    let totalItems = $("#e-order_table tbody tr").length || 1;

    // compute freight per item
    let freightPerItem = freightAmount / totalItems;

    $("#e-order_table tbody tr").each(function () {

        // get supplier_price from column index 3
        let supplierPrice = parseFloat($(this).find("td:eq(3)").text()) || 0;

        // calculate: supplier price + freight per item
        let computed = supplierPrice + freightPerItem;

        // set unit price
        $(this).find(".unit-price").val(computed.toFixed(2));
    });

});


var approve_delivery = (btn) => {
    $('#approve-delivery-modal').modal('show');
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

                // Loop through items | <td data-unit-id="${row.unit_ID}">${row.unit_of_measure ?? ''}
                if (data.items && data.items.length > 0) {
                    data.items.forEach(function (row) {
                        let tr = `
                            <tr>
                                <td>${row.qty ?? ''}</td>
                                <td data-item-id="${row.po_item_id}">${row.item_name ?? ''}</td>
                                <td>${row.strenght ?? ''}</td>
                                <td>${row.supplier_price ?? ''}</td>
                                 <td>
                                    <input type="number" class="form-control form-control-xs unit-price" 
                                        min="0" value="0">
                                </td>
                                <td>
                                    <input type="date" class="form-control form-control-sm item-expiry"
                                        value="${row.date_expiry ? row.date_expiry.split(' ')[0] : ''}">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-xs received-qty" 
                                        min="0" value="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm damaged-pcs" 
                                       value="0" min="0">
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm batch-number" 
                                        value="">
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



$('#approve-delivery').click(function () {
    
    let username = $('#auth-username').val().trim();
    let password = $('#auth-password').val().trim();

    if (username === '' || password === '') {
        toastr.error('Please enter your username and password.');
        return;
    }

    $.ajax({
        url: base_url + 'delivery/validate_user',
        type: 'POST',
        data: { username: username, password: password },

        success: function (res) {
            var res = JSON.parse(res);
            console.log(res);
            if (res.status == 'success') {
                toastr.success('Authentication successful.');
                $('#auth-modal').modal('hide');
                setTimeout(function () {
                    approveDelivery();

                }, 300);

            } else {
                toastr.error("Error: "+ res.message);
            }
        },

        error: function () {
            toastr.error('Server error.');
        }
    });
});

$('#auth-delivery').click(function () {
    $('#auth-username').val('');
    $('#auth-password').val('');

    $('#auth-modal').modal('show');
    $('#auth-modal').on('show.bs.modal', function () {
        // add a special class so we can style its backdrop on top
        $('.modal-backdrop').addClass('auth-backdrop');
    }); 
});

function approveDelivery(){
    let po_number = $('#e-po_number').val();
    let date_in = $('#e-date_in').val();
    let supplier_id = $('#e-supplier').val();
    let received_by = $('#e-recieved_by').val();
    let received_date = $('#e-recieved_date').val();
    let freight = $('#e-freight').val();

    let orderData = [];

    $('#e-order_table tbody tr').each(function () {
        let $tr = $(this);
        let data = {
            qty: $tr.find('td').eq(1).text().trim(),
            item_id: $tr.find('td[data-item-id]').data('item-id') || null,
            item_name: $tr.find('td[data-item-id]').text().trim(),
            // unit_price: $tr.find('td').eq(4).text().trim(),
            unit_price: $tr.find('.unit-price').val() || 0,
            date_expiry: $tr.find('td').eq(5).text().trim(),
            received_qty: $tr.find('.received-qty').val() || 0,
            // received_pcs: $tr.find('.received-pcs').val() || 0,
            damaged_pcs: $tr.find('.damaged-pcs').val() || 0,
            batch_number: $tr.find('.batch-number').val().trim() || ''
        };
        orderData.push(data);
    });

    let payload = {
        po_number: po_number,
        date_in: date_in,
        supplier_id: supplier_id,
        received_by: received_by,
        received_date: received_date,
        freight: freight,
        order_items: orderData
    };

    console.log(payload);


    $.ajax({
        url: base_url + 'delivery/approve_delivery',
        method: 'POST',
        data: { data: JSON.stringify(payload) },
        dataType: 'json',
        success: function (resp) {
            // console.log(resp)
            // var response = JSON.parse(resp);
            // console.log(resp)
            if (resp.status == 'success') {
                toastr.success('Delivery approved successfully!');
                $('#approve-delivery').prop('disabled', true);
                $('#approve-delivery-modal').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 2500);
            } else {
                toastr.error('Failed to save: ' + resp.message);
            }
        },
        error: function (xhr, status, err) {
            console.error(err);
            toastr.error('Error saving data.');
        }
    });
}
    
// Stacked modals helper: dynamically raises z-index for modal + backdrop
// Put this in delivery.js (after jQuery & Bootstrap JS)
// (function ($) {
//     // base z-index for Bootstrap (backdrop 1040, modal 1050). We'll increment from here.
//     var baseBackdropZ = 1040;
//     var baseModalZ = 1050;
//     var zStep = 10;

//     $(document).on('show.bs.modal', '.modal', function (e) {
//         var $opening = $(this);

//         // how many modals already visible (excluding the one opening)
//         var openModals = $('.modal.show').length; // for BS4/5; use :visible fallback for BS3
//         if (openModals === 0) openModals = $('.modal:visible').length;

//         // compute new z-index values
//         var newBackdropZ = baseBackdropZ + (zStep * openModals);
//         var newModalZ = baseModalZ + (zStep * openModals);

//         // apply z-index to the modal (use inline style)
//         $opening.css('z-index', newModalZ);

//         // after a tick the backdrop will be inserted — style it then
//         // select the backdrop(s) that don't have our marker class yet
//         setTimeout(function () {
//             $('.modal-backdrop').not('.modal-stack').each(function (i, el) {
//                 var $back = $(el);
//                 // increment further if multiple backdrops exist
//                 var idx = $('.modal-backdrop.modal-stack').length;
//                 $back.css('z-index', newBackdropZ + (idx * 1)).addClass('modal-stack');
//             });
//         }, 0);

//         // add marker to body so scrolling is prevented correctly
//         $('body').addClass('modal-open');
//     });

//     // When a modal is hidden, remove its z-index and cleanup backdrops
//     $(document).on('hidden.bs.modal', '.modal', function (e) {
//         var $closed = $(this);
//         // remove inline z-index (optional, keeps DOM clean)
//         $closed.css('z-index', '');

//         // remove one backdrop-stack and adjust others if necessary
//         // remove the most recently added backdrop-stack
//         var $stacks = $('.modal-backdrop.modal-stack');
//         if ($stacks.length) {
//             $stacks.last().remove();
//         }

//         // If there are still visible modals, ensure body has modal-open; otherwise remove
//         var stillOpen = $('.modal.show').length;
//         if (stillOpen === 0) {
//             $('body').removeClass('modal-open');
//             // remove any remaining marker class from leftover backdrops
//             $('.modal-backdrop.modal-stack').remove();
//         }
//     });

//     // Extra: handle esc/backdrop clicks when stacking (optional)
//     // Ensures backdrop clicks close only the top modal (Bootstrap does by default).
// })(jQuery);
