<?php
main_header(['top_buyers']);
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
                    <li class="breadcrumb-item active">Top Buyers</li>
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
                            <div class="col-4">
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
                                                    <input type="text" class="form-control date_range" id="sales_date_range">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ml-2 mr-2" id="load_top_buyers">
                    </div>
                </div>
            </div>
        </div>
</section>

<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/rankings/buyers.js"></script>