<table id="example2" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:20%;">Purchase Order #</th>
            <th style="width:20%;">Item Name</th>
            <th style="width:20%;">Supplier</th>
            <th style="width:10%;">Quantity</th>
            <th style="width:25%;">Recieved By</th>
            <th style="width:25%;">Date Encoded</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($history as $key => $value) {
            ?>
            <tr>

                <td><?= $value->po_num ?></td>
                <td><?= $value->item_name ?></td>
                <td><?= $value->supplier_name ?></td>
                <td><?= $value->unit_of_measure=="box" ? intval($value->qty * $value->pcs) : $value->qty ?></td>
                <td><?= $value->received_by ?></td>
                <td><?= date('M d, Y h:i A', strtotime(@$value->date_approved)) ?></td>

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