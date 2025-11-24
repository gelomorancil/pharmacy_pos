<?php load_table_css();?>
<table class="table table-hover text-nowrap datatable" id="userTable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Username</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>