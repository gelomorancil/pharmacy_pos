<?php load_table_css();?>
  <table class="table table-hover text-nowrap datatable" id="itemDeletedTable">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Pricing</th>
            <th>Item Category</th>
            <th>Strenght/Dosage</th>
            <th>Storage Condition</th>
            <th>UOM</th>
            <th>Packaging</th>
            <th>Indication</th>
            <th>Classification</th>
            <th></th>
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
                                <span class="text-success">REGULAR:</span> <?= $value->unit_price ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">WALKIN:</span> <?= $value->Walkin_price ?>
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-success">WHOLESALE:</span> <?= $value->Wholesale_price ?>
                            </small>
                        </div>
                    </div>
                </td>

                <td><?= $value->Category ?></td>
                <td><?= $value->strenght ?></td>
                <td><?= $value->storage_condition ?></td>
                <td><?= $value->uom ?></td>
                <td><?= $value->packaging ?></td>
                <td><?= $value->description ?></td>
                <td><?= $value->classification ?></td>
                <td><button class="btn btn-default btn-sm btn_retrieve" value="<?=$value->id?>">Retrieve</button></td>
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
        let threshold = $(this).data('threshold');

        // Fill the modal fields
        $('#item_profile_id').val(itemId);  // Select item
        $('#unit_price').val(unitPrice);
        $('#walkin_price').val(walkinPrice);
        $('#wholesale_price').val(wholesalePrice);
        $('#edit_item_id').val(itemId);
        $('#threshold').val(threshold);
        $('#item_name_display').text(item_name);

    });
});

$('.btn_retrieve').click(function () {
  $.confirm({
    title: 'Confirmation',
    icon: 'fa fa-question-circle',
    content: 'Are you sure you want to retrieve this item?',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-success',
        action: function () {
          $.post({
            url: base_url+ 'management/service/Management_service/retrieve_item',
            data: {
              id: $('.btn_retrieve').val()
            },
            success: function (e) {
              var e = JSON.parse(e);
              if (!e.has_error) {
                toastr.success(e.message);
              
                setTimeout(function () {
                  window.location.reload();
                }, 500);
              } else {
                toastr.error(e.message);
              }
            },
          });
        },
      },
      cancel: {
        text: 'Cancel',
        btnClass: 'btn-danger',
        action: function () {
        },
      },
    },
  });
});
</script>
