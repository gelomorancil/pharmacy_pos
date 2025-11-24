<?php load_table_css();?>
<table class="table table-hover text-nowrap datatable" id="unit_table">
    <thead>
        <tr>
            <th>Unit</th>
        </tr>
    </thead>
    <tbody>
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
    </tbody>
</table>