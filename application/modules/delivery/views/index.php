<?php
main_header(['delivery']);
$session = (object) get_userdata(USER);

// var_dump($session->FName);
?>

<style>
    /* AUTH MODAL should always appear above any other modal */
    #auth-modal {
        z-index: 1060 !important;
    }

    #auth-modal .modal-dialog {
        z-index: 1070 !important;
    }


    #approve-delivery-modal .modal-dialog {
        z-index: 1065 !important;
        max-width: 80% !important;
    } 
</style>

<div class="row">
    <div class="col-lg-12 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Delivery</h1>
            </div>
            <div class="card-body table-responsive table-smp-0" style="font-size: 12px;">
                <div class="row">
                    <div class="col-12 mb-2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="load_po_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-lg-12 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Delivered Items History</h1>
            </div>
            <div class="card-body table-responsive table-smp-0" style="font-size: 12px;">
                <div class="row">
                    <div class="col-12 mb-2">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="delivered_list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->


<!-- <div class="modal fade" id="modal-stock-in-purchase">
    <div class="modal-dialog modal-lg" style="max-width: 1200px;">
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
                        <input type="text" id="po_number" class="form-control inpt" value="<?= @$PO_num ?>" disabled>
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
                    <div class="col-sm-4">
                        <label for="">Recieved By:</label>
                        <input type="text" id="e-recieved_by" class="form-control inpt"
                            placeholder="User Full Name Here" disabled
                            value="<?= $session->LName . ", " . $session->FName ?>">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Recieved:</label>
                        <input type="date" id="e-recieved_date" class="form-control inpt">
                    </div>
                </div>

                <hr>
                <h5>Order List</h5>
                <table class="table table-bordered table-sm" id="order_table">
                    <thead>
                        <tr>
                            <th>Unit</th>
                            <th>Qty</th>
                            <th>Pcs</th>
                            <th>Item</th>
                            <th>Unit Price</th>
                            <th>Description</th>
                            <th>Date Expiry</th>
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
</div> -->


<div class="modal fade" id="approve-delivery-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 110%;">
            <div class="modal-header">
                <h3 class="modal-title">Approve Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="col-sm-4">
                        <label for="">PO number:</label>
                        <input type="text" id="e-po_number" class="form-control inpt" value="<?= @$PO_num ?>" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Purchased:</label>
                        <input type="date" id="e-date_in" class="form-control inpt" disabled>
                    </div>
                    <div class="col-sm-4">
                        <label for="">Supplier:</label>
                        <select id="e-supplier" class="form-control inpt" disabled>
                            <option selected disabled value="">Supplier</option>
                            <?php foreach ($supplier as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->supplier_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <label for="">Recieved By:</label>
                        <input type="text" id="e-recieved_by" class="form-control inpt"
                            placeholder="User Full Name Here" disabled
                            value="<?= $session->LName . ", " . $session->FName ?>">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Recieved:</label>
                        <input type="date" id="e-recieved_date" class="form-control inpt">
                    </div>
                </div>

                <hr>
                <h5>Order List</h5>
                <table class="table table-bordered table-sm" id="e-order_table">
                    <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Brand</th>
                            <th>Item</th>
                            <!-- <th>Brand</th>  -->
                            <th>Unit Price</th>
                            <th>Date Expiry</th>
                            <th>Recieved Qty</th>
                            <th>Damaged Qty</th>
                            <th>Batch_Number</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="auth-delivery">Approve Delivery
                        Order</button>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="auth-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

            <div class="modal-header">
                <h3 class="modal-title">Authenticate Delivery</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">

                <div class="form-group">
                    <label for="auth-username">Username</label>
                    <input type="text" class="form-control" id="auth-username" placeholder="Enter your username">
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="auth-password">Password</label>
                    <input type="password" class="form-control" id="auth-password" placeholder="Enter your password">
                </div>
            </div>

            <div class="modal-footer">
                <div class="d-flex justify-content-between w-100">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="approve-delivery">Authenticate</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/delivery/delivery.js"></script>