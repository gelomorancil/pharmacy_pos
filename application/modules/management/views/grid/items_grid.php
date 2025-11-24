<?php load_table_css();?>
  <table class="table table-hover text-nowrap datatable" id="itemTable">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Regular Pricing</th>
            <th>Walkin Pricing</th>
            <th>Item Category</th>
            <th>Strenght/Dosage</th>
            <th>Storage Condition</th>
            <th>UOM</th>
            <th>Packaging</th>
            <th>Indication / Category</th>
            <th>Classification</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($items as $key => $value) {
            ?>
            <!-- onclick="editItem(this)"  -->
            <tr 
            data-id="<?=$value->id?>" 
            data-item_name="<?=$value->item_name?>" 
            data-item_code="<?=$value->item_code?>" 
            data-short_name="<?=$value->short_name?>" 
            data-description="<?=$value->description?>" 
            data-category="<?=$value->Category?>" 
            data-status="<?=$value->active?>" 
            data-strenght="<?=$value->strenght?>"
            data-packaging="<?=$value->packaging?>"
            data-uom="<?=$value->uom?>"
            data-classification="<?=$value->classification?>"
            data-storage_condition="<?=$value->storage_condition?>"
            data-item_expiry_date="<?=$value->item_expiry_date?>"
            data-batch_no="<?=$value->batch_no?>"
            data-storage_condition="<?=$value->storage_condition?>"
            >


               <td>
                    <!-- Item name with status circle -->
                    <div class="d-flex align-items-center">
                        <span 
                            class="me-2" 
                            style="
                                display:inline-block;
                                width:10px;
                                height:10px;
                                border-radius:50%;
                                background-color: <?= $value->active == "1" ? 'green' : 'red' ?>;
                            ">
                        </span>
                        <strong><?= $value->item_name ?></strong>
                    </div>

                    <!-- Other details -->
                    <small class="text-muted d-block">
                        <span class="text-danger">GENERIC NAME:</span> <?= $value->short_name ?>
                    </small>
                    <small class="text-muted d-block">
                        <span class="text-danger">MANUFACTURER:</span> <?= $value->item_code ?>
                    </small>
                    <small class="text-muted d-block">
                        <span class="text-danger">DISTRIBUTOR:</span> <?= $value->distributor ?>
                    </small>
                </td>

                <td>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">
                                <span class="text-success">PCS:</span> <?= $value->unit_price ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">STUB:</span> <?= $value->regular_stub ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">BOX:</span> <?= $value->regular_box ?>
                            </small>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <small class="text-muted d-block">
                                <span class="text-success">PCS:</span> <?= $value->Walkin_price ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">STUB:</span> <?= $value->walkin_stub ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">BOX:</span> <?= $value->walkin_box ?>
                            </small>
                        </div>
                        <button 
                            class="btn btn-sm btn-outline-primary ms-2 p-1 edit-price-btn" 
                            title="Edit Prices" 
                            data-toggle="modal" 
                            data-target="#pricingModal"
                            data-id="<?= $value->id ?>"
                            data-unitprice="<?= $value->unit_price ?>"
                            data-walkin="<?= $value->Walkin_price ?>"
                            data-wholesale="<?= $value->Wholesale_price ?>"
                            data-threshold="<?= $value->threshold ?>"
                            data-item_name="<?= $value->item_name ?>"
                            data-regular_stub_price="<?=$value->regular_stub?>" 
                            data-regular_box_price="<?=$value->regular_box?>" 
                            data-walkin_stub_price="<?=$value->walkin_stub?>" 
                            data-walkin_box_price="<?=$value->walkin_box?>" 
                        >
                            <i class="fas fa-edit"></i>
                        </button>

                    </div>
                </td>

                <td><?= $value->Category ?></td>
                <td><?= $value->strenght ?></td>
                <td><?= $value->storage_condition ?></td>
                <td><?= $value->uom ?></td>
                <td><?= $value->packaging ?></td>
                <td><?= $value->description ?></td>
                <td><?= $value->classification ?></td>
            </tr>
        <?php
        }

        ?>
    </tbody>
</table>



<script>
$(document).ready(function() {
    // When edit button is clicked
    $(document).on('click', '.edit-price-btn', function() {
        let itemId = $(this).data('id');
        let item_name = $(this).data('item_name');
        let unitPrice = $(this).data('unitprice');
        let walkinPrice = $(this).data('walkin');
        let wholesalePrice = $(this).data('wholesale');
        let regular_stub_price = $(this).data('regular_stub_price');
        let regular_box_price = $(this).data('regular_box_price');
        let walkin_stub_price = $(this).data('walkin_stub_price');
        let walkin_box_price = $(this).data('walkin_box_price');
        let threshold = $(this).data('threshold');

        // Fill the modal fields
        $('#item_profile_id').val(itemId);  // Select item
        $('#unit_price').val(unitPrice);
        $('#walkin_price').val(walkinPrice);
        $('#wholesale_price').val(wholesalePrice);
        $('#edit_item_id').val(itemId);
        $('#threshold').val(threshold);
        $('#regular_stub_price').val(regular_stub_price);
        $('#regular_box_price').val(regular_box_price);
        $('#walkin_stub_price').val(walkin_stub_price);
        $('#walkin_box_price').val(walkin_box_price);
        $('#item_name_display').text(item_name);

    });
});
</script>
