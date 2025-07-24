<?php
if (!empty($items)) {
    foreach ($items as $key => $value) { ?>
        <tr class="item-row text-center">
            <td><b><?= $key + 1?></b></td>
            <td><?= $value->item_code ?></td>
            <td><?= $value->item_name ?></td>
            <td><b style="color: green;"><?= $value->sale_quantity ?></b></td>
        </tr>
    <?php }
} else {
    ?>
    <tr>
        <td class="text-center" colspan="4">NO DATA</td>
    </tr>
<?php } ?>