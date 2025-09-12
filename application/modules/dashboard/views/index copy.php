<?php
main_header(['dashboard']);
?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-body table-responsive p-0 card-success" style="height: 50vh;">
                        <div class="card-header">
                            <div class="car-tools m-2">
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <h4><b>TOP SELLING ITEMS:</b></h4>
                                    </div>

                                    <div class="col-3">
                                        <label for="month">Select Month:</label>
                                        <select id="month" name="month" class="form-control">
                                            <!-- Month options will be populated by JavaScript -->
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="year">Select Year:</label>

                                        <select id="year" name="year" class="form-control">
                                            <!-- Generate options dynamically in JavaScript for a range of years -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-hover text-nowrap table-sm table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th>Rank</th>
                                    <th>Item Code</th>
                                    <th>Item Name</th>
                                    <th>Monthly Sales (QTY)</th>
                                </tr>
                            </thead>
                            <tbody id="top_items">
                                <!-- Top Items Table Loaded Here via JS -->
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-12" id="top_items_chart">
                        <!-- Top Items Chart Loaded Here Via JS -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- <h3 class="card-title">Dashboard</h3> -->
            <div class="col-4">
                <div class="card card-danger">
                    <div class="card-header text-center">
                        <h3 class="card-title">Items Low on Stock</h3>
                    </div>
                    <form>
                        <div class="card-body" style="height: 43.2vh;">
                            <div id="load_inventory">
                                <!-- Inventory Loaded here via JS -->
                            </div>
                        </div>
                        <div class="card-footer">
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0" style="height: 50vh;">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-10">
                                            <h4><b>MONTHLY SALES</b></h4>
                                        </div>
                                        <div class="col-2">
                                            <select class="form-control" style="width: 100%;" id="sales_year">
                                                <?php $date = date('Y'); ?>
                                                <option selected="selected" value="<?= $date ?>"><?= $date ?></option>
                                                <option value="<?= $date - 1 ?>"><?= $date - 1 ?></option>
                                                <option value="<?= $date - 2 ?>"><?= $date - 2 ?></option>
                                                <option value="<?= $date - 3 ?>"><?= $date - 3 ?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-hover text-nowrap table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>MONTH</th>
                                            <th>SALES</th>
                                        </tr>
                                    </thead>
                                    <tbody id="report-summary">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-12" id="load_monthly_sales">
                        Monthly Sales Loaded Here Via JS
                        <?php
                        // include('grid/chart.php');
                        ?>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/dashboard/dashboard.js"></script>