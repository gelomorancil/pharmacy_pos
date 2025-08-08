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
    data-status="<?=$value->active?>" 
    >


        <td><?= $value->item_name ?></td>
        <td><?= $value->item_code ?></td>
        <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
            <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
        </td>
        <td><?=date("M d, Y", strtotime( @$value->item_expiry_date)) ?></td>
    </tr>
<?php
}

?>