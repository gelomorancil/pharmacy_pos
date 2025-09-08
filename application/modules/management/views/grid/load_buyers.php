<?php
    $prevCat = '';
    foreach($buyers as $key => $value){ 
    ?>
    <tr  onClick="editFunctionBuyers(<?=$value->ID?>)" >
        <td id="name" value="asd"><?=ucfirst($value->FName)?></td>
        <td><?=$value->CNum?></td>
    </tr>
<?php   
}

?>