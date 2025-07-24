<table id="example2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:20%;">Item Code</th>
            <th style="width:20%;">Item Name</th>
            <th style="width:20%;">Supplier</th>
            <th style="width:10%;">Quantity</th>
            <th style="width:25%;">Date Encoded</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($history as $key => $value) {
            ?>
            <tr>

                <td><?= $value->item_code ?></td>
                <td><?= $value->item_name ?></td>
                <td><?= $value->supplier_name ?></td>
                <td><?= $value->quantity ?></td>
                <td><?= date('M d, Y h:i A', strtotime($value->date_created)) ?></td>

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