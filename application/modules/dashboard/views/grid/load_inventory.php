<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:20%;">Item Code</th>
            <th style="width:30%;">Item Name</th>
            <th style="width:20%;">Current Stocks</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($inventory as $key => $value) {
            ?>
            <tr>

                <td><?= $value->item_code ?></td>
                <td><?= $value->item_name ?></td>
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
        "autoWidth": false,
        "searching": false,
        "ordering": false, // Enable sorting generally
        "columnDefs": [
            { "orderable": false, "targets": [0, 1] } // Disable sorting for the first two columns
        ],
        // "order": [[ 3, "asc" ]],
        // "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 5,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>