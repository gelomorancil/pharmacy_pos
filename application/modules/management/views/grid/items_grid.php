<?php load_table_css();?>
  <table class="table table-hover text-nowrap datatable" id="itemTable">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Strenght/Dosage</th>
            <th>UOM</th>
            <th>Packaging</th>
            <th>Indication / Category</th>
            <th>Classification</th>
            <th>Item Category</th>
            <th>Expiry Date</th>
            <th>Batch No</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($items as $key => $value) {
            ?>
            <tr onclick="editItem(this)" 
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
            >


                <td>
                    <?= $value->item_name ?><br>
                    <small class="text-muted"><span class="text-danger">GENERIC:</span><?= $value->short_name ?></small><br>
                    <small class="text-muted"><span class="text-danger">CODE:</span><?= $value->item_code ?></small>
                </td>
                <td><?= $value->strenght ?></td>
                <td><?= $value->uom ?></td>
                <td><?= $value->packaging ?></td>
                <td><?= $value->description ?></td>
                <td><?= $value->classification ?></td>
                <td><?= $value->Category ?></td>
                <td><?= $value->item_expiry_date ?></td>
                <td><?= $value->batch_no ?></td>
                <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
                    <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
                </td>
            </tr>
        <?php
        }

        ?>
    </tbody>
</table>