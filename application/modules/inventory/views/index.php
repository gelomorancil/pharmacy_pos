<?php
main_header(['inventory']);
$session = (object) get_userdata(USER);

// var_dump($session->FName);
?>
<!-- ############ PAGE START-->
<input hidden id="created_by" value="<?= $session->ID ?>">
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Inventory</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Inventory</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body table-responsive table-smp-0" style="font-size: 12px;">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <button type="button" class="btn btn-success" id="stock_in">Stock-In</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div id="load_inventory"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- <<==============================================>> MODALS <<==============================================>> -->
<div class="modal fade" id="modal-stock-in">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Stock-in</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="">Select Item:</label>
                        <select name="" id="item" class="form-control inpt">
                            <option selected disabled value="">Select Item</option>
                            <?php
                            foreach ($items_profiles as $value) {
                                ?>
                                <option value="<?= $value->id ?>"> <?= $value->item_name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Quantiy:</label>
                        <input type="number" id="quantity" class="form-control inpt" placeholder="Enter quantity">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Select Supplier:</label>
                        <select name="" id="supplier" class="form-control inpt">
                            <option selected disabled value="">Select Supplier</option>
                            <?php
                            foreach ($supplier as $value) {
                                ?>
                                <option value="<?= $value->id ?>"> <?= $value->supplier_name ?></option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Date Received:</label>
                        <input type="date" id="date_in" class="form-control inpt">
                    </div>
                    <div class="col-sm-6">
                        <label for="">Recieved By:</label>
                        <input type="text" id="recieved_by" class="form-control inpt" placeholder="User Full Name Here"
                            disabled value="<?=$session->LName . ", " .  $session->FName?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="add_stock">Add Stock</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="modal-stock-history">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Stock History:</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="load_history_data"></div>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <!-- <button type="button" class="btn btn-sm btn-success" id="add_stock">Add Stock</button> -->
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/inventory/inventory.js"></script>