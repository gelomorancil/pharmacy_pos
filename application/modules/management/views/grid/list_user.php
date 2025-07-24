<?php
    $prevCat = '';
    foreach($user as $key => $value){ 
    ?>
    <tr  onClick="editFunction(<?=$value->ID?>)" >
        <td id="name" value="asd"><?=ucfirst($value->LName.", ".ucfirst($value->FName))?></td>
        <td><?=$value->Username?></td>
        <td><?=ucfirst($value->Role)?></td>
    </tr>
<?php   
}

?>