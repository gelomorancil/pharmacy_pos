<?php
main_header(['summary_report']);
?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <!-- <h1 class="m-0">List Management</h1> -->
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Sales Report</a></li>
                    <li class="breadcrumb-item active">Report</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <h3 class="text-bold">OVERALL SALES</h3>
        <!-- BAGO NI SA -->
        <div class="row mb-2" <?=empty($session->Branch) ? '' : 'hidden'?>>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" style="width: 100%;" id="Branch">
                    <option value="" disabled selected>Select Branch</option>
                    <option value="All">All</option>
                    <?php
                        foreach($branch as $key => $value){ ?>
                            <option value="<?=$value->List_name?>"><?=$value->List_name?></option>
                        <?php }
                    ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h4 class="text-bold"><?= number_format($sales, 2) ?></h4>

                        <p>Sales</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="text-bold"><?= number_format($expense - 0, 2) ?></h4>

                        <p>Expenses</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h4 class="text-bold"><?= number_format($sales - $expense, 2) ?></h4>

                        <p>Profit</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-6 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="text-bold"><?= number_format($cash, 2) ?></h4>

                        <p>Cash</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <div class="col-lg-6 col-sm-12">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h4 class="text-bold"><?= number_format($online, 2) ?></h4>

                        <p>Online Payment</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <!-- <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a> -->
                </div>
            </div>
            <!-- ./col -->
        </div>

        <div class="divider bg-primary">
            <hr>
        </div>

        <h3 class="text-bold">MONTHLY SALES</h3>
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-6">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <div class="card-header">
                                    <select class="form-control select2" style="width: 25%;" id="sales-year">
                                        <?php $date = date('Y'); ?>
                                        <option selected="selected" value="<?= $date ?>"><?= $date ?></option>
                                        <option value="<?= $date - 1 ?>"><?= $date - 1 ?></option>
                                        <option value="<?= $date - 2 ?>"><?= $date - 2 ?></option>
                                        <option value="<?= $date - 3 ?>"><?= $date - 3 ?></option>
                                    </select>
                                </div>
                                <table class="table table-hover text-nowrap table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>MONTH</th>
                                            <th>SALES</th>
                                            <th>EXPENSES</th>-
                                            <th>PROFIT</th>
                                        </tr>
                                    </thead>
                                    <tbody id="report-summary">
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-12 col-sm-6">
                        <!-- haha -->
                        <?php include('grid/chart.php'); ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="card">
                            <div class="card-body table-responsive p-0">
                                <div class="card-header text-center">
                                    <h4>TOP ITEMS</h4>
                                    <!-- <select class="form-control select2" style="width: 25%;" id="sales-year">
                                    <?php $date = date('Y'); ?>
                                    <option selected="selected" value="<?= $date ?>"><?= $date ?></option>
                                    <option value="<?= $date - 1 ?>"><?= $date - 1 ?></option>
                                    <option value="<?= $date - 2 ?>"><?= $date - 2 ?></option>
                                    <option value="<?= $date - 3 ?>"><?= $date - 3 ?></option>
                                </select> -->
                                </div>
                                <table class="table table-hover text-nowrap table-sm table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Items</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody id="list-items">
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?php include('grid/item_chart.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    </div>
    </div>
</section>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/report/report.js"></script>