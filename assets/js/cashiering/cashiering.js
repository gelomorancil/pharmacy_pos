// alert();
// var load_scanned_items = () => {
//     $(document).gmLoadPage({
//         url: 'cashiering/load_scanned_items',
//         load_on: '#load_items'
//     });
// }

var load_inventory = () => {
    $(document).gmLoadPage({
        url: 'cashiering/load_inventory',
        load_on: '#load_item_table'
    });
}

$('#discount').on('blur', function () {
    if ($(this).val().trim() === '') {
        $(this).val(0);
    }
});

$(document).ready(function () {
    // load_scanned_items();
});

// Leaving Page Warning
// window.addEventListener('beforeunload', function (e) {
//     let message = 'Warning! Are you sure you want to leave this page? Any unsaved data will be lost';
//     e.returnValue = message;
//     return message;
// });

// On pressing Enter trigger submit
$(document).on('keydown', function (e) {
    if (e.key === "Enter" || e.keyCode === 13) {
        e.preventDefault(); // Prevent the default form submission behavior

        // Check if the modal is open
        if ($('#modal-enter-item').hasClass('show')) {
            $('#add_item').click();
            $('#item_code').val("");
        }
        else if ($('#modal-update-item').hasClass('show')) {
            $('#update_item').click();
        }
        else if ($('#modal-tender-customer').hasClass('show')) {
            $('#save_print').click();
        }
        else {
            $('#submit_item_code').click();
        }
    }
});

// Discount on input value checker
// document.getElementById('discount').addEventListener('input', function () {
//     const quantityInput = this;
//     const value = quantityInput.value;

//     const validInputPattern = /^[0-9]*%?$/;

//     if (!validInputPattern.test(value)) {
//         toastr.error('Please enter a valid number (letters and special characters are not allowed).');
//         quantityInput.value = '';
//         return;
//     }

//     const numericValue = parseFloat(value.replace('%', ''));

//     if (numericValue < 0 || numericValue > 100) {
//         toastr.error('Please enter a valid percentage between 0 and 100.');
//         quantityInput.value = '';
//     }
// });

// Add percentage sign on blur
// document.getElementById('discount').addEventListener('blur', function () {
//     const quantityInput = this;
//     const value = quantityInput.value;

//     if (value !== '' && !isNaN(parseFloat(value.replace('%', ''))) && parseFloat(value.replace('%', '')) >= 0 && parseFloat(value.replace('%', '')) <= 100) {
//         quantityInput.value = value.replace('%', '') + '%';
//     }
// });

$('#submit_item_code').click(function () {
    // alert("Submit button clicked!");
    $.post({
        url: 'cashiering/check_item_code',
        data: {
            item_code: $('#item_code').val(),
        },
        success: function (e) {
            var e = JSON.parse(e);
            if (!e.has_error) {
                toastr.success(e.message);
                // console.log(e.query);

                $('#display_item_name').text(e.query[0].item_name);
                $('#item_profile_id').val(e.query[0].id);
                $('#item_name').val(e.query[0].item_name);
                $('#code').val(e.query[0].item_code);
                $('#price').val(e.query[0].unit_price);
                $('#short_name').val(e.query[0].short_name);
                $('#item_description').val(e.query[0].description);



                $('#modal-enter-item').modal('show');


                $('#item_code').val("");

                // setTimeout(function () {
                //     window.location.reload();
                // }, 500);
            } else {
                toastr.error(e.message);
                $('#item_code').val("");
                $("#item_code").focus();

            }
        },
    });
});

$('#add_item').click(function () {

    add_item(
        $('#item_profile_id').val(),
        $('#code').val(),
        $('#item_name').val(),
        $('#item_description').val(),
        parseFloat($('#price').val()).toFixed(2),
        parseInt($('#quantity').val()),
        parseFloat($('#discount').val()).toFixed(2),
        ((parseFloat($('#price').val()).toFixed(2) * parseInt($('#quantity').val())) - parseFloat($('#discount').val()).toFixed(2)).toFixed(2)
    );

    $("#item_code").focus();

});

$('#update_item').click(function () {
    let updatedQuantity = $('#update_quantity').val();
    let updatedDiscount = $('#update_discount').val();

    let price = parseFloat($(currentRow).find('td').eq(4).text());
    let newTotal = (updatedQuantity * price) - updatedDiscount;
    newTotal = newTotal.toFixed(2);

    $(currentRow).find('td').eq(5).text(updatedQuantity);
    $(currentRow).find('td').eq(6).text(updatedDiscount);
    $(currentRow).find('td').eq(7).text(newTotal);

    // Display Last Scanned Item Details
    display_item_details($(currentRow).find('td').eq(1).text(), $(currentRow).find('td').eq(3).text(), updatedQuantity, updatedDiscount, newTotal);
    display_sales_sub_totals()

    $('#modal-update-item').modal('hide');
});

$('#bill_20').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 20).toFixed(2));
    $('#amount_recieved').trigger('input');
});
$('#bill_50').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 50).toFixed(2));
    $('#amount_recieved').trigger('input');
});
$('#bill_100').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 100).toFixed(2));
    $('#amount_recieved').trigger('input');
});
$('#bill_200').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 200).toFixed(2));
    $('#amount_recieved').trigger('input');
});
$('#bill_500').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 500).toFixed(2));
    $('#amount_recieved').trigger('input');
});
$('#bill_1000').click(function () {
    $('#amount_recieved').val((parseFloat($('#amount_recieved').val()) + 1000).toFixed(2));
    $('#amount_recieved').trigger('input');
});



$('#search_item').click(function () {
    load_inventory();
    $('#modal-search-item').modal('show');
});

$('#tend_customer').click(function () {
    $('#tender_total_amount').text($('#total_amount_due').text());
    $('#modal-tender-customer').modal('show');
});

document.getElementById('amount_recieved').addEventListener('blur', function () {
    const amount_recieved = this;
    const value = parseFloat(amount_recieved.value).toFixed(2);
    this.value = value;
});

$('#amount_recieved').on('input', function () {
    let total_amount_due = parseFloat($('#tender_total_amount').text()).toFixed(2);
    let amount_rendered = parseFloat($('#amount_recieved').val()).toFixed(2);
    let change = parseFloat(amount_rendered - total_amount_due).toFixed(2);

    $('#change').val(change);

    if (change < 0) {
        $('#change').css('background-color', 'lightcoral');
    }
    else {
        $('#change').css('background-color', 'lightgreen');
    }
});

$('#save_print').click(function () {
    if ($('#payment_type').val() == "ONLINE") {
        $('#modal-online-payment-details').modal('show');
    }
    else {
        process_payment()
    }
});

$('#online_proceed').click(function () {
    process_payment()
});

$('#new_transaction').click(function () {
    window.location.reload();
});



// <<=======================================================>> STAND ALONE FUNCTIONS <<=======================================================>>

function process_payment() {

    // Data for Parent Table
    let sub_total = $('#amount_due').text();
    let discount_amount = parseFloat($('#total_discounts').text()).toFixed(2);
    let total_amount = $('#total_amount_due').text();
    let discount_type = $('#discount_type').val();
    let payment_type = $('#payment_type').val();
    let amount_rendered = $('#amount_recieved').val();
    let reference_number = $('#reference_number').val();
    let remarks = $('#remarks').val();

    // Data for tbl_proof
    let imageFile = $("#proof_image")[0].files[0];

    // Data for Child Table
    const tableBody = document.querySelector('#scanned_items');

    let itemsArray = [];

    const rows = tableBody.querySelectorAll('tr');

    rows.forEach(row => {
        const cells = row.querySelectorAll('td');

        if (cells.length === 8) {

            const item = {
                item_profile_id: cells[0].innerText.trim(),
                // item_code: cells[1].innerText.trim(),
                item_name: cells[2].innerText.trim(),
                // description: cells[3].innerText.trim(),
                unit_price: parseFloat(cells[4].innerText.trim()),
                quantity: parseInt(cells[5].innerText.trim(), 10),
                discount: parseFloat(cells[6].innerText.trim()),
                total: parseFloat(cells[7].innerText.trim())
            };

            itemsArray.push(item);
        }
    });
    // console.log(itemsArray);
    if (parseFloat(amount_rendered) == 0 || parseFloat(amount_rendered) < parseFloat(total_amount)) {
        toastr.error("Not Enough Money Rendered!");
        return;
    }

    var formData = new FormData();
    // For tbl_payment_parent
    formData.append("sub_total", sub_total);
    formData.append("discount_amount", discount_amount);
    formData.append("total_amount", total_amount);
    formData.append("discount_type", discount_type);
    formData.append("payment_type", payment_type);
    formData.append("amount_rendered", amount_rendered);
    formData.append("reference_number", reference_number);
    formData.append("remarks", remarks);

    // For tbl_proof
    formData.append("image", imageFile);

    // For tbl_payment_child
    formData.append("itemsArray", JSON.stringify(itemsArray));

    $.ajax({
        type: "POST",
        url: "cashiering/service/Cashiering_service/process_payment",
        data: formData,
        processData: false,
        contentType: false, // Prevent jQuery from automatically setting the Content-Type header
        success: function (response) {
            var e = JSON.parse(response);
            if (e.has_error == false) {
                toastr.success(e.message);

                // function showPrintConfirmation() {
                //     $.confirm({
                //         title: 'Print Confirmation',
                //         content: 'Confirm if Receipt Printing is Successful',
                //         buttons: {
                //             reprint: {
                //                 text: 'Reprint',
                //                 btnClass: 'btn-blue',
                //                 action: function () {
                //                     // Reprint the receipt by calling the $.post again
                //                     $.post({
                //                         url: 'cashiering/Cashiering/load_receipt',
                //                         data: {
                //                             control_number: e.control_number,
                //                             sub_total: sub_total,
                //                             discount_amount: discount_amount,
                //                             total_amount: total_amount,
                //                             discount_type: discount_type,
                //                             data_array: itemsArray,
                //                         },
                //                         success: function (data) {
                //                             $('#to_be_printed').html(data);
                //                             $("#to_be_printed").printThis({
                //                                 debug: false,
                //                                 importCSS: true,
                //                                 importStyle: true,
                //                                 printContainer: true,
                //                                 removeInline: false,
                //                                 printDelay: 333,
                //                                 header: null,
                //                                 footer: null,
                //                                 base: false,
                //                                 formValues: true,
                //                                 removeScripts: false,
                //                                 copyTagClasses: false,
                //                                 beforePrintEvent: null,
                //                                 beforePrint: null,
                //                                 afterPrint: function () {
                //                                     showPrintConfirmation(); // Call confirmation again after reprint
                //                                 }
                //                             });
                //                         }
                //                     });
                //                 }
                //             },
                //             confirm: {
                //                 text: 'Confirm',
                //                 btnClass: 'btn-green',
                //                 action: function () {
                //                     window.location.reload(); // Refresh the page
                //                 }
                //             },
                //         }
                //     });
                // }

                // Initial post and print
                $.post({
                    url: 'cashiering/Cashiering/load_receipt',
                    data: {
                        control_number: e.control_number,
                        sub_total: sub_total,
                        discount_amount: discount_amount,
                        total_amount: total_amount,
                        discount_type: discount_type,
                        data_array: itemsArray,
                    },
                    success: function (data) {
                        $('#to_be_printed').html(data);
                        $("#to_be_printed").printThis({
                            debug: false,               // show the iframe for debugging
                            importCSS: true,            // import parent page css
                            importStyle: true,          // import style tags
                            printContainer: true,       // print outer container/$.selector
                            removeInline: false,        // remove inline styles from print elements
                            printDelay: 333,            // variable print delay
                            header: null,               // prefix to html
                            footer: null,               // postfix to html
                            base: false,                // preserve the BASE tag or accept a string for the URL
                            formValues: true,           // preserve input/form values
                            removeScripts: false,       // remove script tags from print content
                            copyTagClasses: false,      // copy classes from the html & body tag
                            beforePrintEvent: null,     // function for printEvent in iframe
                            beforePrint: null,          // function called before iframe is filled
                            afterPrint: function () {
                                // showPrintConfirmation(); // Show confirmation after the first print
                                $('#payment_type').prop('disabled', true);
                                $('#discount_type').prop('disabled', true);
                                $('#amount_recieved').prop('disabled', true);
                                $('#bill_20').prop('disabled', true);
                                $('#bill_50').prop('disabled', true);
                                $('#bill_100').prop('disabled', true);
                                $('#bill_200').prop('disabled', true);
                                $('#bill_500').prop('disabled', true);
                                $('#bill_1000').prop('disabled', true);

                                $('#cancel_payment').prop('hidden', true);
                                $('#add_remarks').prop('hidden', true);
                                $('#save_print').prop('hidden', true);

                                $('#new_transaction').prop('hidden', false);


                                $('#modal-tender-customer').modal('show');
                            }
                        });
                    }
                });

            } else {
                toastr.error(e.message);
            }
        },
        error: function () {
            toastr.error("An error occurred during the upload.");
        }
    });


}

function add_item(item_profile_id, item_code, item_name, description, price, new_quantity, discount, item_total) {

    const itemProfileID = item_profile_id;
    const itemCode = item_code;
    const itemName = item_name;
    const itemDescription = description;
    const itemPrice = price;
    const newItemQuantity = new_quantity;
    const itemDiscount = discount;
    const itemTotal = item_total;

    let existingRow = $('#scanned_items tr').filter(function () {
        return $(this).find('td').eq(1).text() === itemCode && $(this).find('td').eq(2).text() === itemName;
    });

    if (existingRow.length > 0) {
        let currentQuantity = parseInt(existingRow.find('td').eq(5).text());
        let combinedQuantity = currentQuantity + newItemQuantity;

        check_item_stock(itemCode, combinedQuantity)
            .then(function (isInStock) {
                if (isInStock) {
                    low_stock_warning(itemCode).then(function (lowStockConfirm) {
                        if (lowStockConfirm) {

                            $.confirm({
                                title: 'Confirmation',
                                icon: 'fa fa-exclamation-circle',
                                content: 'Current Item is LOW in Stock. Proceed?',
                                buttons: {
                                    Proceed: {
                                        text: 'Proceed',
                                        btnClass: 'btn-success',
                                        action: function () {
                                            $('#modal-enter-item').modal('hide');

                                            existingRow.find('td').eq(5).text(combinedQuantity);

                                            let newTotal = ((itemPrice * combinedQuantity) - itemDiscount).toFixed(2);
                                            existingRow.find('td').eq(7).text(newTotal);

                                            // Display Last Scanned Item Details
                                            display_item_details(itemName, itemPrice, combinedQuantity, itemDiscount, newTotal);
                                            display_sales_sub_totals()
                                        },
                                    },
                                    Cancel: {
                                        text: 'Cancel',
                                        btnClass: 'btn-danger',
                                        action: function () {
                                        },
                                    },
                                },
                            });
                        }
                        else {
                            $('#modal-enter-item').modal('hide');

                            existingRow.find('td').eq(5).text(combinedQuantity);

                            let newTotal = ((itemPrice * combinedQuantity) - itemDiscount).toFixed(2);
                            existingRow.find('td').eq(7).text(newTotal);

                            // Display Last Scanned Item Details
                            display_item_details(itemName, itemPrice, combinedQuantity, itemDiscount, newTotal);
                            display_sales_sub_totals();
                        }
                    });
                } else {
                    // Do nothing
                }
            });
    } else {
        check_item_stock(itemCode, newItemQuantity)
            .then(function (isInStock) {
                if (isInStock) {
                    low_stock_warning(itemCode).then(function (lowStockConfirm) {
                        if (lowStockConfirm) {
                            $.confirm({
                                title: 'Confirmation',
                                icon: 'fa fa-exclamation-circle',
                                content: 'Current Item is LOW in Stock. Proceed?',
                                buttons: {
                                    Proceed: {
                                        text: 'Proceed',
                                        btnClass: 'btn-success',
                                        action: function () {
                                            $('#modal-enter-item').modal('hide');

                                            let newRow = `
                                                <tr onclick="item_options(this)">
                                                    <td hidden>${itemProfileID}</td>
                                                    <td>${itemCode}</td>
                                                    <td>${itemName}</td>
                                                    <td>${itemDescription}</td>
                                                    <td>${itemPrice}</td> 
                                                    <td>${newItemQuantity}</td>
                                                    <td>${itemDiscount}</td>
                                                    <td>${itemTotal}</td> 
                                                </tr>
                                            `;
                                            $('#scanned_items').append(newRow);

                                            // Display Last Scanned Item Details
                                            display_item_details(itemName, itemPrice, newItemQuantity, itemDiscount, itemTotal);
                                            display_sales_sub_totals()
                                        },
                                    },
                                    Cancel: {
                                        text: 'Cancel',
                                        btnClass: 'btn-danger',
                                        action: function () {
                                        },
                                    },
                                },
                            });
                        }
                        else {
                            $('#modal-enter-item').modal('hide');

                            let newRow = `
                                <tr onclick="item_options(this)">
                                    <td hidden>${itemProfileID}</td>
                                    <td>${itemCode}</td>
                                    <td>${itemName}</td>
                                    <td>${itemDescription}</td>
                                    <td>${itemPrice}</td> 
                                    <td>${newItemQuantity}</td>
                                    <td>${itemDiscount}</td>
                                    <td>${itemTotal}</td> 
                                </tr>
                            `;
                            $('#scanned_items').append(newRow);

                            // Display Last Scanned Item Details
                            display_item_details(itemName, itemPrice, newItemQuantity, itemDiscount, itemTotal);
                            display_sales_sub_totals()
                        }
                    });

                } else {
                    // Do nothing
                }
            });
    }

    $('#quantity').val("");
    $('#discount').val("0");
}

let currentRow;
function item_options(row) {
    // console.log(row);

    let cells = row.getElementsByTagName('td');

    let item_code = cells[1].textContent.trim();
    let item_name = cells[2].textContent.trim();
    let description = cells[3].textContent.trim();
    let price = parseFloat(cells[4].textContent.trim());
    let quantity = cells[5].textContent.trim();
    let discount = parseFloat(cells[6].textContent.trim());
    let total = cells[7].textContent.trim();

    console.log(item_code, item_name, description, price, quantity, discount, total);

    $.confirm({
        title: 'Item Options',
        icon: 'fa fa-exclamation-circle',
        content: 'Select Desired Action',
        buttons: {
            Edit: {
                text: 'Edit',
                btnClass: 'btn-primary',
                action: function () {
                    $('#update_quantity').val(quantity);
                    $('#update_discount').val(discount);

                    currentRow = row;
                    $('#modal-update-item').modal('show');

                },
            },
            Delete: {
                text: 'Delete',
                btnClass: 'btn-danger',
                action: function () {
                    $.confirm({
                        title: 'Confirm Deletion',
                        icon: 'fa fa-exclamation-circle',
                        buttons: {
                            Confirm: {
                                text: 'Confirm',
                                btnClass: 'btn-danger',
                                action: function () {
                                    $(row).remove();
                                    display_sales_sub_totals_delete(quantity,price,discount);
                                },
                            },
                            Cancel: {
                                text: 'Cancel',
                                btnClass: 'btn-secondary',
                                action: function () {
                                    // Do nothing
                                },
                            },
                        }
                    })
                },
            },
            Cancel: {
                text: 'Cancel',
                btnClass: 'btn-secondary',
                action: function () {
                },
            },
        },
    });
}

function select_item(row) {

    let cells = row.getElementsByTagName('td');
    let item_code = cells[0].textContent.trim();

    $('#modal-search-item').modal('hide');

    $.post({
        url: 'cashiering/check_item_code',
        data: {
            item_code: item_code,
        },
        success: function (e) {
            var e = JSON.parse(e);
            if (!e.has_error) {
                toastr.success(e.message);
                // console.log(e.query);

                $('#display_item_name').text(e.query[0].item_name);
                $('#item_profile_id').val(e.query[0].id);
                $('#item_name').val(e.query[0].item_name);
                $('#code').val(e.query[0].item_code);
                $('#price').val(e.query[0].unit_price);
                $('#short_name').val(e.query[0].short_name);
                $('#item_description').val(e.query[0].description);

                $('#modal-enter-item').modal('show');


                $('#item_code').val("");

                // setTimeout(function () {
                //     window.location.reload();
                // }, 500);
            } else {
                toastr.error(e.message);
            }
        },
    });
}

function check_item_stock(item_code, quantity) {

    const tbody = document.getElementById("scanned_items");
    let currentQuantity;

    for (let row of tbody.rows) {
        if (row.cells[1].textContent.trim() === item_code) {
            currentQuantity = parseInt(row.cells[5].textContent.trim());
            break;
        }
    }

    return new Promise(function (resolve, reject) {
        $.post({
            url: 'cashiering/check_item_stock',
            data: {
                item_code: item_code,
                quantity: quantity,
                current_quantity: currentQuantity,
            },
            success: function (response) {
                var e = JSON.parse(response);
                if (!e.has_error) {
                    toastr.success(e.message);
                    resolve(true);
                } else {
                    toastr.error(e.message);
                    resolve(false);
                }
            },
            error: function () {
                toastr.error('Error checking stock.');
                reject(false);
            }
        });
    });
}

function update_main_total_amount_due(amount) {
    $('#main_total_amount_due').text(amount);
}

function display_item_details(item_name, price, quantity, discount, total) {
    $('#last_item_name').text(item_name);
    $('#last_item_price').text(price);
    $('#last_item_quantity').text(quantity);
    $('#last_item_discount').text(discount);
    $('#last_item_total').text(total);
}

function display_sales_sub_totals() {
    let totalQuantity = 0;
    let totalDiscount = 0;
    let totalPriceDiscounted = 0;

    $('#scanned_items tr').each(function () {
        let quantity = parseInt($(this).find('td').eq(5).text()) || 0;
        let discount = parseFloat($(this).find('td').eq(6).text()) || 0;
        let total_price_discounted = parseFloat($(this).find('td').eq(7).text()) || 0;

        totalQuantity += quantity;
        totalDiscount += discount;
        totalPriceDiscounted += total_price_discounted;
    });

    totalDiscount = totalDiscount.toFixed(2);
    totalPriceDiscounted = totalPriceDiscounted.toFixed(2);

    $('#amount_due').text((parseFloat(totalPriceDiscounted) + parseFloat(totalDiscount)).toFixed(2));
    $('#total_quantity').text(totalQuantity);
    $('#total_discounts').text(totalDiscount);
    $('#total_amount_due').text(totalPriceDiscounted);

    update_main_total_amount_due(totalPriceDiscounted);
}

function display_sales_sub_totals_delete(qty, price, discount) {
    alert();
    let totalQuantity = parseInt($('#total_quantity').text()) - qty;
    let totalDiscount = parseFloat($('#total_discounts').text()) - discount;
    let totalPriceDiscounted = parseFloat($('#total_amount_due').text()) - (qty * price) + discount;
    console.log(totalQuantity, totalDiscount, totalPriceDiscounted);
    $('#amount_due').text((parseFloat(totalPriceDiscounted) + parseFloat(totalDiscount)).toFixed(2));
    $('#total_quantity').text(totalQuantity);
    $('#total_discounts').text(totalDiscount.toFixed(2));
    $('#total_amount_due').text(totalPriceDiscounted.toFixed(2));
    $('#last_item_total').text(0);
    $('#last_item_discount').text(0);
    $('#last_item_quantity').text(0);
    $('#last_item_price').text(0);
    $('#last_item_name').text("- -");

    update_main_total_amount_due(totalPriceDiscounted.toFixed(2));

}

function low_stock_warning(itemCode) {

    return new Promise(function (resolve, reject) {
        $.post({
            url: 'cashiering/check_stock_status',
            data: {
                item_code: itemCode,
            },
            success: function (response) {
                let data = JSON.parse(response)
                // console.log(data.length);
                if (data.length > 0) {
                    resolve(true);
                } else {
                    resolve(false);
                }
            },
            error: function () {
                toastr.error('Error checking stock.');
                reject(false);
            }
        });
    });
}





