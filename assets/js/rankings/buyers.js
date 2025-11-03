let current_date_range = $('.date_range').val(); // use let (not const) so it can change
const current_load_type = $('#data_type_to_load').val();

// Date range picker
$('#sales_date_range').daterangepicker({
    locale: {
        format: 'MMM D, YYYY' // Format for Oct 21, 2024
    },
    startDate: moment().startOf('month'), // First day of the current month
    endDate: moment().endOf('month')      // Last day of the current month
});

// Update the variable when the date is changed
$('#sales_date_range').on('change', function () {
    current_date_range = $(this).val(); // update the global variable
    load_top_buyers(); // reload data with new date
});

function load_top_buyers() {
    $.ajax({
        url: 'top_buyers/load_top_buyers',
        type: 'POST',
        data: {
            date: current_date_range, // always uses the latest date
        },
        success: function (response) {
            $('#load_top_buyers').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

$(document).ready(function () {
    load_top_buyers();
});
