<?php load_table_css();?>
  <table class="table table-hover text-nowrap datatable" id="itemTable">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Item Description</th>
            <th>Item Category</th>
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
            >


                <td>
                    <?= $value->item_name ?><br>
                    <small class="text-muted"><?= $value->item_code ?></small>
                </td>
                <td><?= $value->description ?></td>
                <td><?= $value->Category ?></td>
                <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
                    <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
                </td>
            </tr>
        <?php
        }

        ?>
    </tbody>
</table>