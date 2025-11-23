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
                                <td>${row.unit_price ?? ''}</td>
                                <td>
                                    <input type="date" class="form-control form-control-sm item-expiry"
                                        value="${row.date_expiry ? row.date_expiry.split(' ')[0] : ''}">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-xs damaged-qty" 
                                        min="0" value="0">
                                </td>
                                <td>
                                    <input type="number" class="form-control form-control-sm received-qty" 
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
    let po_number = $('#e-po_number').val();
    let date_in = $('#e-date_in').val();
    let supplier_id = $('#e-supplier').val();
    let received_by = $('#e-recieved_by').val();
    let received_date = $('#e-recieved_date').val();

    let orderData = [];

    $('#e-order_table tbody tr').each(function () {
        let $tr = $(this);
        let data = {
            qty: $tr.find('td').eq(1).text().trim(),
            item_id: $tr.find('td[data-item-id]').data('item-id') || null,
            item_name: $tr.find('td[data-item-id]').text().trim(),
            unit_price: $tr.find('td').eq(4).text().trim(),
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
        order_items: orderData
    };

    console.log(payload);

    $.ajax({
        url: base_url + 'delivery/approve_delivery',
        method: 'POST',
        data: { data: JSON.stringify(payload) },
        dataType: 'json',
        success: function (res) {
            if (res.status === 'success') {
                toastr.success('Delivery approved successfully!');
                $('#approve-delivery').prop('disabled', true);
                $('#approve-delivery-modal').modal('hide');
                setTimeout(function () {
                    location.reload();
                }, 2500);
            } else {
                toastr.error('Failed to save: ' + res.message);
            }
        },
        error: function (xhr, status, err) {
            console.error(err);
            toastr.error('Error saving data.');
        }
    });
});