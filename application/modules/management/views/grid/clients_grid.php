<?php load_table_css();?>
<table class="table table-hover text-nowrap datatable" id="clientTable">
    <thead>
        <tr>
            <th>Client Name</th>
            <th>Contact Number</th>
            <th>LTO Number</th>
            <th>Email Address</th>
            <th>Company Affiliate</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
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
    data-lto="<?=$value->lto?>" 
    >


        <td><?= $value->name ?></td>
        <td><?= $value->cnum ?></td>
        <td><?= $value->lto ?></td>
        <td><?= $value->email ?></td>
        <td><?= $value->affiliate??'-'?></td>
        <td style="color: <?= $value->active == "1" ? 'green' : 'red' ?>">
            <b><?= $value->active == "1" ? 'Active' : 'In-active' ?></b>
        </td>
    </tr>
<?php
}

?>
    </tbody>
</table>