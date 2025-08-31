<style>
    .inventory-div thead tbody tr {
        display: block;
      width: 100%;
      table-layout: fixed;
    }
</style>
<table id="example1" class="table table-bordered table-striped inventory-div">
    <thead>
        <tr>
            <th style="width:10%;">Item Code</th>
            <th style="width:30%;">Item Name</th>
            <th style="width:30%;">Description</th>
            <th style="width:10%;">Current Stocks</th>
            <th style="width:10%;">Actions</th>
        </tr>
    </thead>
    <tbody clas>
        <?php
        $prevCat = '';
        foreach ($inventory as $key => $value) {
            ?>
            <tr>

                <td><?= $value->item_code ?></td>
                <td><?= $value->item_name ?></td>
                <td><?= $value->description ?></td>
                <td>
                    <b style="color: 
                        <?php
                        if ($value->current_stock <= $value->threshold) {
                            echo 'red';
                            $iconColor = 'red';
                            $iconMessage = 'Stock is below threshold!'; 
                        } elseif ($value->current_stock >= 1.40 * $value->threshold) {
                            echo 'green';
                            $iconColor = ''; 
                            $iconMessage = ''; 
                        } elseif ($value->current_stock >= 1.05 * $value->threshold) {
                            echo 'orange';
                            $iconColor = 'orange'; 
                            $iconMessage = 'Stock is getting low!'; 
                        } else {
                            echo 'black';
                            $iconColor = ''; 
                            $iconMessage = ''; 
                        }
                        ?>">
                        <?= $value->current_stock ?>
                    </b>

                    <?php if ($iconColor): // Check if icon color is set ?>
                        <i class="fas fa-exclamation-circle" style="color: <?= $iconColor ?>;" title="<?= $iconMessage ?>"></i>
                    <?php endif; ?>
                </td>


                <td>
                    <button type="button" class="btn btn-sm btn-primary" data-itemID="<?= $value->item_ID ?>"
                        onclick="view_history(this)">View Stock History</button>
                </td>

            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script>
    $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        // "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 15,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>