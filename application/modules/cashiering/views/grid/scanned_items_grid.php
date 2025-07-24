<table id="example2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:15%;">Item Code</th>
            <th style="width:15%;">Item Name</th>
            <th style="width:30%;">Description</th>
            <th style="width:10%;">Price</th>
            <th style="width:10%;">Quantity</th>
            <th style="width:10%;">Discount</th>
            <th style="width:10%;">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($items)) {
            foreach ($items as $key => $value) {
                ?>
                <tr>

                    <td><?= $value->item_code ?></td>
                    <td><?= $value->item_name ?></td>
                    <td><?= $value->description ?></td>
                    <td><?= $value->unit_price ?></td>
                    <td><?= $value->quantity ?></td>
                    <td><?= $value->item_name ?></td>
                    <td><?= $value->item_name ?></td>

                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="7" class="text-center">No Available Data</td>
            </tr>
            <?php
        }

        ?>
    </tbody>
</table>

<script>
    $("#example2").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "searching": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 10,
    }).buttons().container();
</script>