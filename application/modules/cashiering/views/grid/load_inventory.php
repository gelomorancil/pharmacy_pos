<style>
    .full-width-search {
        width: 100%;
        text-align: left;
    }

    .full-width-search label {
        font-size: 120%;
        font-weight: bold;
        display: flex;
        width: 100%;
    }

    .full-width-search input {
        flex-grow: 1;
        width: 100%;
        max-width: 100%;
        padding: 8px;
        font-size: 14px;
    }
</style>
<table id="example1" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th style="width:15%;">Item Code</th>
            <th style="width:30%;">Item Name</th>
            <th style="width:30%;">Description</th>
            <th style="width:20%;">Stock</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($inventory as $key => $value) {
            ?>
            <tr onclick="select_item(this)">

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
        "pageLength": 10,
        "dom": '<"top"f>rt<"bottom"lp><"clear">'
    });

    // Apply full-width class to the search filter
    $('#example1_filter').addClass('full-width-search');
</script>