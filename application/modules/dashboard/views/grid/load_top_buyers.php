<?php
if (!empty($buyers)) {
    foreach ($buyers as $key => $value) { ?>
        <tr class="">
            <td><b><?= $key + 1?></b></td>
            <td><?= $value->buyer_name ?></td>
            <!-- <td><?= $value->item_name ?></td> -->
            <td><b style="color: green;">&#8369 <?= number_format($value->sale_quantity,2)?></b></td>
        </tr>
    <?php }
} else {
    ?>
    <tr>
        <td class="text-center" colspan="4">NO DATA</td>
    </tr>
<?php } ?>