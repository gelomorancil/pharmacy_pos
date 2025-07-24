<?php
$prevCat = '';
foreach ($units as $key => $value) {
    ?>
    <tr onclick="deletUnit(this)" 
    data-id="<?=$value->id?>" 
    data-item_name="<?=$value->unit_of_measure?>"
    >

        <td><?= $value->unit_of_measure ?></td>
    </tr>
<?php
}

?>