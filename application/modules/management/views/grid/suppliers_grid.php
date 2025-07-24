<?php
$prevCat = '';
foreach ($suppliers as $key => $value) {
    ?>
    <tr onclick="editSupplier(this)" 
    data-id="<?=$value->id?>" 
    data-supplier_name="<?=$value->supplier_name?>"
    data-address="<?=$value->address?>"
    data-contact_person="<?=$value->contact_person?>"
    data-contact_number_1="<?=$value->contact_number_1?>"
    data-contact_number_2="<?=$value->contact_number_2?>"
    data-email="<?=$value->email?>"
    data-active="<?=$value->active?>"
    >


        <td><?= $value->supplier_name ?></td>
        <td><?= $value->contact_person ?></td>
        <td><?= $value->contact_number_1 ?> / <?= $value->contact_number_2 ?></td>
        <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
            <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
        </td>
    </tr>
<?php
}

?>