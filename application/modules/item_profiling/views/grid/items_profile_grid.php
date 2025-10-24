<?php load_table_css();?>
<table class="table table-hover text-nowrap datatable" id="items_profile_table">
    <thead>
        <tr>
            <th>Brand Name</th>
            <th>Unit</th>
            <th>Unit Price</th>
            <th>Walkin Price</th>
            <th>Wholesale Price</th>
            <th>Threshold</th>
        </tr>
    </thead>
    <tbody>
        <?php
            $prevCat = '';
            foreach ($items_profiles as $key => $value) {
                ?>
                <tr onclick="editProfile(this)" 
                data-id="<?=$value->id?>" 
                data-item_id="<?=$value->item_id?>" 
                data-unit_id="<?=$value->unit_id?>" 
                data-unit_price="<?=$value->unit_price?>" 
                data-walkin_price="<?=$value->Walkin_price?>" 
                data-wholesale_price="<?=$value->Wholesale_price?>" 
                data-regular_stub_price="<?=$value->regular_stub?>" 
                data-regular_box_price="<?=$value->regular_box?>" 
                data-walkin_stub_price="<?=$value->walkin_stub?>" 
                data-walkin_box_price="<?=$value->walkin_box?>" 
                data-threshold="<?=$value->threshold?>" 
                >


                    <td><?= $value->item_name ?></td>
                    <td><?= $value->unit_of_measure ?></td>
                    <td>Php <?= number_format($value->unit_price, 2) ?></td>
                    <td>Php <?= number_format($value->Walkin_price, 2) ?></td>
                    <td>Php <?= number_format($value->Wholesale_price, 2) ?></td>
                    <td><?= $value->threshold ?></td>

                </tr>
            <?php
            }

            ?>

    </tbody>
</table>