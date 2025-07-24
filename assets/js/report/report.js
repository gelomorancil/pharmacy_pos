//Date range picker
$('#sales_date_range').daterangepicker({
    locale: {
        format: 'MMM D, YYYY' // Format for Oct 21, 2024
    },
    startDate: moment().startOf('month'), // First day of the current month
    endDate: moment().endOf('month')      // Last day of the current month
});

const current_date_range = $('.date_range').val();
const current_load_type = $('#data_type_to_load').val();

function load_sales_report(date_range, load_type) {
    $.ajax({
        url: 'report/load_sales_report',
        type: 'POST',
        data: {
            date_range: date_range,
            load_type: load_type
        },
        success: function (response) {
            $('#load_report').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

function load_inventory_report(date_range) {
    $.ajax({
        url: 'report/load_inventory_report',
        type: 'POST',
        data: {
            date_range: date_range,
        },
        success: function (response) {
            $('#load_report').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}


$(document).ready(function () {
    load_sales_report(current_date_range, current_load_type);
});

// $('#edit_details').click(function () {
//     // alert($('#parent_id').val());
//     // return;
//     $('#view-individual-item').modal('hide');
//     $('#edit-individual-item').modal('show');
// });

$('.date_range, #data_type_to_load, #report_type').change(function () {
    const dateRange = $('.date_range').val();
    const dataType = $('#data_type_to_load').val();
    const reportType = $('#report_type').val();

    if (reportType === "sales") {
        load_sales_report(dateRange, dataType);
        $('#type_of_report').text('Sales');
        $('#sales_data_types').show();
    }
    else if (reportType === "inventory") {
        load_inventory_report(dateRange);
        $('#type_of_report').text('Inventory');
        $('#sales_data_types').hide();
    }
});




// Global Variables
let items_array = null;

let date_created = null;
let control_number = null;
let sub_total = null;
let discount = null;
let discount_type = null;
let total_amount = null;

function show_individual_items(data) {
    let childrenData = data.getAttribute('data-children-array');
    let children = JSON.parse(childrenData);

    $('#parent_id').val(data.getAttribute('data-parent_id'));

    $.ajax({
        url: 'report/load_individual_items',
        type: 'POST',
        data: {
            children_array: children,
        },
        success: function (response) {
            $('#load_individual_items').html(response);
            $('#view-individual-item').modal('show');

            // Update Global Variables
            items_array = children;
            date_created = data.getAttribute('data-date_created');
            control_number = data.getAttribute('data-control_number');
            sub_total = data.getAttribute('data-sub_total');
            discount = data.getAttribute('data-discount');
            discount_type = data.getAttribute('data-discount_type');
            total_amount = data.getAttribute('data-total_amount');
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });

    // console.log(children);
}

$('#void_sale').click(function () {
    $.confirm({
        title: 'Confirm Void Action',
        icon: 'fa fa-exclamation',
        content: 'Are you sure you want to Void this transaction? once CONFIRMED, void action CANNOT BE REVERTED',
        buttons: {
            Confirm: {
                text: 'Confirm',
                btnClass: 'btn-danger',
                action: function () {
                    $.ajax({
                        url: 'report/service/Report_service/void_transaction',
                        type: 'POST',
                        data: {
                            pParentID: $('#parent_id').val(),
                        },
                        success: function (response) {
                            toastr.success("Transaction Voided");
                            $('#view-individual-item').modal('hide');
                            load_sales_report($('.date_range').val(), $('#data_type_to_load').val());
                        },
                        error: function (xhr, status, error) {
                            console.error("Error loading sales:", error);
                        }
                    });
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
});

$('#reprint_receipt').click(function () {
    $.post({
        url: 'report/load_receipt',
        data: {
            control_number: control_number,
            sub_total: sub_total,
            discount_amount: parseFloat(discount).toFixed(2),
            total_amount: total_amount,
            discount_type: discount_type,
            data_array: items_array,
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
                }
            });
        }
    });
});

