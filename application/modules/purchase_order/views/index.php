<?php
main_header(['purchase_order']);
$session = (object) get_userdata(USER);

// var_dump($session->FName);
?>
<style>

  /* Change hover color to light gray */
    .select2-results__option--highlighted {
        background-color: #f2f2f2 !important; /* light gray background */
        color: #000 !important; /* black text */
    }

    /* Optional: make the cursor consistent */
    .select2-results__option {
        cursor: pointer;
    }

    .select2-results__options {
        max-height: 400px !important;  /* default is ~200px */
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-6 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h3 class="m-0">Purchase Order List</h1>
            </div>
            <div class="card-body table-responsive table-smp-0" style="font-size: 12px;">
                <div class="row">
                    <div class="col-12 mb-2">
                        <!-- <button type="button" class="btn btn-success" id="stock_in">Stock-In</button> -->
                        <button type="button" class="btn btn-success" id="stock_in_purchase">Purchase
                            Order</button>
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


<div class="modal fade" id="modal-stock-in-purchase">
    <div class="modal-dialog modal-xl">
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
                        <input type="text" id="po_number" class="form-control inpt" value="<?= @$PO_num ?>">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Purchased:</label>
                        <input type="date" id="date_in" class="form-control inpt" value="<?= date('Y-m-d') ?>">
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
                    <div class="col-sm-8">
                        <label for="">Select Item:</label>
                         <select id="item" class="select2 form-control" style="width: 100%;">
                            <option value="" disabled selected>-- Select Category --</option>
                            <?php foreach($items_profiles as $key => $value){ ?>
                                <option 
                                    value="<?= $value->item_id ?>"
                                    data-id="<?=$value->item_id?>" 
                                    data-item_name="<?=$value->item_name?>" 
                                    data-item_code="<?=$value->item_code?>" 
                                    data-short_name="<?=$value->short_name?>" 
                                    data-description="<?=$value->description?>" 
                                    data-category="<?=$value->category?>" 
                                    data-status="<?=$value->active?>" 
                                    data-strenght="<?=$value->strenght?>"
                                    data-packaging="<?=$value->packaging?>"
                                    data-uom="<?=$value->uom?>"
                                    data-classification="<?=$value->classification?>"
                                    data-storage_condition="<?=$value->storage_condition?>"
                                    data-distributor="<?=$value->distributor?>">
                                    <?= $value->item_name ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-sm-2">
                        <div class="form-group w-100">
                            <label for="">Unit of Measure:</label>
                            <select class="form-control" style="width: 100%;" id="unit_id" disabled>
                                <?php
                                foreach ($units as $value) {
                                    ?>
                                    <option value="<?= $value->id ?>"><?= $value->unit_of_measure ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div> -->
                    <div class="col-sm-2">
                        <label for="">Quantity:</label>
                        <input type="number" id="quantity_po" class="form-control inpt" placeholder="Enter quantity">
                    </div>
                    <!-- <div class="col-sm-2">
                        <label for="">Pcs:</label>
                        <input type="number" id="po-pcs" class="form-control inpt" placeholder="Enter pcs" disabled>
                    </div> -->
                    <!-- <div class="col-sm-2">
                        <label for="">Unit Price:</label>
                        <input type="number" id="unit_price" class="form-control inpt" placeholder="Enter Unit Price">
                    </div> -->
                    <div class="col-sm-4">
                        <label for="">Recieved By:</label>
                        <input type="text" id="recieved_by" class="form-control inpt" placeholder="User Full Name Here"
                            disabled value="<?= $session->LName . ", " . $session->FName ?>">
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-sm-5">
                        <label for="">Item Description:</label>
                        <input type="text" id="item_desc" class="form-control inpt" placeholder="Item Description">
                    </div> -->
                    <!-- <div class="col-sm-3">
                        <label for="">Threshold:</label>
                        <input type="number" id="threshold" class="form-control inpt" placeholder="Enter Threshold">
                    </div> -->
                    <!-- <div class="col-sm-4">
                        <label for="">Date Expiry:</label>
                        <input type="date" id="date_expiry" class="form-control inpt" value="<?= date('Y-m-d') ?>">
                    </div> -->


                    <div class="col-sm-12 text-right mt-2">
                        <button type="button" class="btn btn-primary btn-sm" id="add_to_table">+ Add Item</button>
                    </div>

                </div>

                <hr>
                <h5>Order List</h5>
                <table class="table table-bordered table-sm" id="order_table">
                    <thead>
                        <tr>
                            <!-- <th>Unit</th> -->
                            <th>Qty</th>
                            <!-- <th>Pcs</th> -->
                            <th>Item</th>
                            <th>Dosage</th>
                            <th>Supplier Price</th>
                            <!-- <th>Unit Price</th> -->
                            <!-- <th>Description</th> -->
                            <!-- <th>Date Expiry</th> -->
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


<div class="modal fade" id="edit-po-modal">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Purchase Order</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="">PO number:</label>
                        <input type="text" id="e-po_number" class="form-control inpt">
                        <input type="text" id="e-po_number-id" class="form-control inpt"  style="display: none;">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Date Purchased:</label>
                        <input type="date" id="e-date_in" class="form-control inpt">
                    </div>
                    <div class="col-sm-4">
                        <label for="">Select Supplier:</label>
                        <select id="e-supplier" class="form-control inpt">
                            <option selected disabled value="">Select Supplier</option>
                            <?php foreach ($supplier as $value): ?>
                                <option value="<?= $value->id ?>"><?= $value->supplier_name ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-8">
                        <label for="">Select Item:</label>
                        <select id="item_2" class="select2 form-control" style="width: 100%;">
                            <option value="" disabled selected>-- Select Category --</option>
                            <?php foreach($items_profiles as $key => $value){ ?>
                                <option 
                                     value="<?= $value->item_id ?>"
                                    data-id="<?=$value->item_id?>" 
                                    data-item_name="<?=$value->item_name?>" 
                                    data-item_code="<?=$value->item_code?>" 
                                    data-short_name="<?=$value->short_name?>" 
                                    data-description="<?=$value->description?>" 
                                    data-category="<?=$value->category?>" 
                                    data-status="<?=$value->active?>" 
                                    data-strenght="<?=$value->strenght?>"
                                    data-packaging="<?=$value->packaging?>"
                                    data-uom="<?=$value->uom?>"
                                    data-classification="<?=$value->classification?>"
                                    data-storage_condition="<?=$value->storage_condition?>"
                                    data-distributor="<?=$value->distributor?>">
                                    <?= $value->item_name ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-sm-2"> -->
                        <!-- <div class="form-group w-100">
                            <label for="">Unit of Measure:</label>
                            <select class="form-control" id="e-unit_id">
                                <?php foreach ($units as $value): ?>
                                    <option value="<?= $value->id ?>"><?= $value->unit_of_measure ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div> -->
                    <!-- </div> -->
                    <!-- <div class="col-sm-2">
                        <label for="">Pcs:</label>
                        <input type="number" id="e-po-pcs" class="form-control inpt" placeholder="Enter pcs" disabled>
                    </div> -->
                    <div class="col-sm-2">
                        <label for="">Quantity:</label>
                        <input type="number" id="e-quantity_po" class="form-control inpt" placeholder="Enter quantity">
                    </div>
                    <!-- <div class="col-sm-3">
                        <label for="">Unit Price:</label>
                        <input type="number" id="e-unit_price" class="form-control inpt" placeholder="Enter Unit Price">
                    </div> -->
                    <div class="col-sm-4">
                        <label for="">Recieved By:</label>
                        <input type="text" id="e-recieved_by" class="form-control inpt"
                            placeholder="User Full Name Here" disabled
                            value="<?= $session->LName . ", " . $session->FName ?>">
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-sm-5">
                        <label for="">Item Description:</label>
                        <input type="text" id="e-item_desc" class="form-control inpt" placeholder="Item Description">
                    </div> -->
                    <!-- <div class="col-sm-3">
                        <label for="">Threshold:</label>
                        <input type="number" id="e-threshold" class="form-control inpt" placeholder="Enter Threshold">
                    </div> -->

                    <div class="col-sm-12 text-right mt-2">
                        <button type="button" class="btn btn-primary btn-sm" id="e-add_to_table">+ Add Item</button>
                    </div>
                </div>

                <hr>
                <h5>Order List</h5>
                <table class="table table-bordered table-sm" id="e-order_table">
                    <thead>
                        <tr>
                            <!-- <th>Unit</th> -->
                            <th>Qty</th>
                            <!-- <th>Pcs</th> -->
                            <th>Item</th>
                            <th>Dosage</th>
                            <th>Supplier Price</th>
                            <!-- <th>Description</th> -->
                            <!-- <th>Date Expiry</th> -->
                            <!-- <th>Threshold</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

            </div>
            <div class="modal-footer">
                <div class="justify-content-between">
                    <button type="button" class="btn btn-sm btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-success" id="update-po">Update Order</button>
                </div>
            </div>

        </div>
    </div>
</div>

<?php
main_footer();
?>
<script>
        $('#item, #item_2').select2({
        width: '100%',
        dropdownParent: $('body'),
        matcher: function(params, data) {
            if ($.trim(params.term) === '') return data;

            const term = params.term.toLowerCase();
            const text = (data.text || '').toLowerCase();
            let found = text.indexOf(term) > -1;

            if (!found && data.element) {
                const $option = $(data.element);
                $.each($option.data(), function(key, value) {
                    if (String(value).toLowerCase().indexOf(term) > -1) {
                        found = true;
                        return false;
                    }
                });
            }
            return found ? data : null;
        },
        // templateResult: function(option) {
        //     if (!option.id) return option.text;

        //     const data = $(option.element).data();
        //     const statusColor = data.status == 1 ? 'green' : 'red';

        //     return $`
        //         <div class="p-1">
        //             <div class="d-flex justify-content-between align-items-start mb-1">
        //                 <div>
        //                     <div class="d-flex align-items-center">
        //                         <span style="
        //                             display:inline-block;
        //                             width:10px;
        //                             height:10px;
        //                             border-radius:50%;
        //                             background:${statusColor};
        //                             margin-right:6px;
        //                         "></span>
        //                         <strong>${data.item_name || option.text}</strong>
        //                     </div>
        //                     <small class="text-muted d-block mt-1">
        //                         <span class="text-danger">GENERIC NAME:</span> ${data.short_name || '-'}
        //                     </small>
        //                     <small class="text-muted d-block">
        //                         <span class="text-danger">MANUFACTURER:</span> ${data.item_code || '-'}
        //                     </small>
        //                     <small class="text-muted d-block">
        //                         <span class="text-danger">DISTRIBUTOR:</span> ${data.distributor || '-'}
        //                     </small>
        //                 </div>
        //             </div>

        //             <div class="border-top pt-1">
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">CATEGORY:</span> ${data.category || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">STRENGTH:</span> ${data.strenght || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">STORAGE:</span> ${data.storage_condition || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">UOM:</span> ${data.uom || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">PACKAGING:</span> ${data.packaging || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">DESCRIPTION:</span> ${data.description || '-'}
        //                 </small>
        //                 <small class="text-muted d-block">
        //                     <span class="text-primary">CLASSIFICATION:</span> ${data.classification || '-'}
        //                 </small>
        //             </div>
        //         </div>
        //     `;
        // },
        templateResult: function(option) {
            if (!option.id) return option.text;

            const data = $(option.element).data();
            const statusColor = data.status == 1 ? 'green' : 'red';

            let html = `
                <div class="p-1">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <div class="d-flex align-items-center">
                                <span style="
                                    display:inline-block;
                                    width:10px;
                                    height:10px;
                                    border-radius:50%;
                                    background:${statusColor};
                                    margin-right:6px;
                                "></span>
                                <strong>${data.item_name || option.text}</strong>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <span class="text-danger">GENERIC NAME:</span> ${data.short_name || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">MANUFACTURER:</span> ${data.item_code || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">DISTRIBUTOR:</span> ${data.distributor || '-'}
                            </small>
                        </div>
                    </div>

                    <div class="border-top pt-1">
                        <small class="text-muted d-block">
                            <span class="text-primary">CATEGORY:</span> ${data.category || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STRENGTH:</span> ${data.strenght || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STORAGE:</span> ${data.storage_condition || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">UOM:</span> ${data.uom || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">PACKAGING:</span> ${data.packaging || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">DESCRIPTION:</span> ${data.description || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">CLASSIFICATION:</span> ${data.classification || '-'}
                        </small>
                    </div>
                </div>
            `;

            return $(html);  // <-- required fix
        },

        // templateSelection: function(option) {
        //     if (!option.id) return option.text;
        //     const data = $(option.element).data();
        //     return data.item_name || option.text;
        // },
        templateSelection: function(option) {
            if (!option.id) return option.text;
            const data = $(option.element).data();
            return data.item_name || option.text;
        },
        escapeMarkup: function(m) { return m; } // Allow HTML rendering
    });

    // $('#item_2').select2('destroy');
    // $('#item_2').select2();
    $(document).on('select2:open', () => {
        setTimeout(() => {
            const field = document.querySelector('.select2-container--open .select2-search__field');
            field.focus();
            field.select();
        }, 10);
    });

</script>
<script src="<?php echo base_url() ?>/assets/js/inventory/po.js"></script>