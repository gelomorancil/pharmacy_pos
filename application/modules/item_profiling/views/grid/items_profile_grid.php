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