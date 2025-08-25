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
                                <button type="button" class="btn btn-success" id="stock_in_purchase">Purchase Order</button>
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
<!-- <div class="modal fade" id="modal-stock-in">
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
                    <div class="col-sm-4">
                        <label for="">PO number:</label>
                        <input type="text" id="po_number" class="form-control inpt" placeholder="Enter Purchas Order Number">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Received:</label>
                        <input type="date" id="date_in" class="form-control inpt">
                    </div>
                    <div class="col-sm-4">
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
</div> -->

<div class="modal fade" id="modal-stock-in-purchase">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Purchase Order</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="">PO number:</label>
                        <input type="text" id="po_number" class="form-control inpt" value="<?=@$PO_num?>" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Purchased:</label>
                        <input type="date" id="date_in" class="form-control inpt">
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
                    <div class="col-sm-2">
                        <div class="form-group w-100">
                            <label for="">Unit of Measure:</label>
                            <select class="form-control" style="width: 100%;" id="unit_id">
                                <?php
                                foreach ($units as $value) {
                                    ?>
                                    <option value="<?= $value->id ?>"><?= $value->unit_of_measure ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <label for="">Quantity:</label>
                        <input type="number" id="quantity_po" class="form-control inpt" placeholder="Enter quantity">
                    </div>
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
                    <div class="col-sm-3">
                        <label for="">Unit Price:</label>
                        <input type="number" id="unit_price" class="form-control inpt" placeholder="Enter Unit Price">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-5">
                        <label for="">Item Description:</label>
                        <input type="text" id="item_desc" class="form-control inpt" placeholder="Item Description">
                    </div>
                    <div class="col-sm-1">
                        <label for="">Branded?</label>
                        <input type="checkbox" id="branded_flag" class="form-control inpt">
                    </div>
                    <div class="col-sm-2">
                        <label for="">Threshold:</label>
                        <input type="number" id="threshold" class="form-control inpt" placeholder="Enter Threshold">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Recieved By:</label>
                        <input type="text" id="recieved_by" class="form-control inpt" placeholder="User Full Name Here"
                            disabled value="<?=$session->LName . ", " .  $session->FName?>">
                    </div>

                    <div class="col-sm-12 text-right mt-2">
                        <button type="button" class="btn btn-primary btn-sm" id="add_to_table">+ Add Item</button>
                    </div>

                </div>

                <hr>
                <h5>Order List</h5>
                <table class="table table-bordered table-sm" id="order_table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Item</th>
                            <th>Unit Price</th>
                            <th>Description</th>
                            <th>Branded</th>
                            <th>Threshold</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="add_stock_po">Make Order</button>
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