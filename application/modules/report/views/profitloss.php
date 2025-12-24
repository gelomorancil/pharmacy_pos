<?php
main_header(['profitloss']);
$session = (object) get_userdata(USER);

?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0">Dashboard</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Profit / Loss Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <!-- <div class="col-8">
                                <div class="col-3">
                                    <label for="">Select Type of Report:</label>
                                    <select id="report_type" class="form-control">
                                        <option selected value="sales">Sales</option>
                                        <option value="inventory">Inventory</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card-tools">
                                            <div class="input-group input-group-sm mb-2">
                                                <label for="">Select Date Range:</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="far fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control date_range" id="profitloss_date_range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="">
                                    <button class="btn btn-sm btn-primary mt-4" onclick="printTable()">
                                        <i class="fas fa-print"></i> Print
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="print-area">
                        <div class="ml-2 mr-2" id="load_profitloss_report">
                            <!-- Report Content Loaded Here Via JS -->
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>
</section>


<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/report/report.js"></script>
<script>
function printTable() {
    var printContents = document.getElementById('print-area').innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = `
        <html>
        <head>
            <title>Print</title>
            <link rel="stylesheet" href="plugins/bootstrap/css/bootstrap.min.css">
            <link rel="stylesheet" href="dist/css/adminlte.min.css">
            <style>
                body {
                    padding: 20px;
                }
                table {
                    font-size: 12px;
                }
            </style>
        </head>
        <body>
            ${printContents}
        </body>
        </html>
    `;

    window.print();
    document.body.innerHTML = originalContents;
    location.reload(); // restores JS, DataTables, etc.
}
</script>
