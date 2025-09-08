<?php
$prevCat = '';
foreach ($items_profiles as $key => $value) {
    ?>
    <tr onclick="editProfile(this)" 
    data-id="<?=$value->id?>" 
    data-item_id="<?=$value->item_id?>" 
    data-unit_id="<?=$value->unit_id?>" 
    data-unit_price="<?=$value->unit_price?>" 
    data-threshold="<?=$value->threshold?>" 
    >


        <td><?= $value->item_name ?></td>
        <td><?= $value->unit_of_measure ?></td>
        <!-- <td>Php <?= number_format($value->unit_price, 2) ?></td> -->
        <td><?= $value->threshold ?></td>

    </tr>
<?php
}

?>