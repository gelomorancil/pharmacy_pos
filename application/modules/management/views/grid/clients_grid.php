<?php

foreach ($clients as $key => $value) {
    ?>
    <tr onclick="editClient(this)" 
    data-id="<?=$value->ID?>" 
    data-name="<?=$value->name?>" 
    data-affiliate="<?=$value->affiliate?>" 
    data-cnum="<?=$value->cnum?>" 
    data-email="<?=$value->email?>" 
    data-status="<?=$value->active?>" 
    >


        <td><?= $value->name ?></td>
        <td><?= $value->affiliate??'-'?></td>
        <td><?= $value->cnum ?></td>
        <td><?= $value->email ?></td>
        <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
            <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
        </td>
    </tr>
<?php
}

?>