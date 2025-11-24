// For Year
const yearSelect = document.getElementById('year');
const currentYear = new Date().getFullYear();
const startYear = currentYear - 15; // Adjust range as needed
const endYear = currentYear + 10;   // Adjust range as needed

for (let year = startYear; year <= endYear; year++) {
    const option = document.createElement('option');
    option.value = year;
    option.textContent = year;

    if (year === currentYear) {
        option.selected = true; // Automatically select the current year
    }

    yearSelect.appendChild(option);
}

// For Month
const monthSelect = document.getElementById('month');
const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December", "All"
];
const currentMonth = new Date().getMonth(); // 0-based index for current month

// Generate month options
monthNames.forEach((month, index) => {
    const option = document.createElement('option');
    const monthValue = (index + 1).toString().padStart(2, '0'); // Formats as "01", "02", etc.
    option.value = monthValue;
    option.textContent = month;

    if (index === currentMonth) {
        option.selected = true;
    }

    monthSelect.appendChild(option);
});

// Get Combined Date Function
function getCombinedDate() {
    const selectedYear = yearSelect.value;
    const selectedMonth = monthSelect.value;
    const combinedDate = `${selectedYear}-${selectedMonth}`;
    return combinedDate;
}

var load_inventory = () => {
    $(document).gmLoadPage({
        url: 'dashboard/load_inventory',
        load_on: '#load_inventory'
    });
}

function load_top_items(date) {
    $.ajax({
        url: 'dashboard/load_top_items',
        type: 'POST',
        data: {
            date: date,
        },
        success: function (response) {
            $('#top_items').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

function load_top_buyers(date) {
    $.ajax({
        url: 'dashboard/load_top_buyers',
        type: 'POST',
        data: {
            date: date,
        },
        success: function (response) {
            $('#top_buyers').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

function load_top_items_chart(date) {
    $.ajax({
        url: 'dashboard/load_top_items_chart',
        type: 'POST',
        data: {
            date: date,
        },
        success: function (response) {
            $('#top_items_chart').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

function load_monthly_sales(year) {
    $.ajax({
        url: 'dashboard/load_monthly_sales',
        type: 'POST',
        data: {
            year: year,
        },
        success: function (response) {
            $('#report-summary').html(response);
        },
        error: function (xhr, status, error) {
            console.error("Error loading sales:", error);
        }
    });
}

$(document).ready(function () {
    load_inventory();
    load_top_items(getCombinedDate());
    load_top_buyers(getCombinedDate());
    load_top_items_chart(getCombinedDate());
    load_monthly_sales($('#sales_year').val());
});

$('#month, #year').change(function () {
    load_top_items(getCombinedDate());
    load_top_buyers(getCombinedDate());
    load_top_items_chart(getCombinedDate());
});

$('#sales_year').change(function () {
    load_monthly_sales($('#sales_year').val());
});
