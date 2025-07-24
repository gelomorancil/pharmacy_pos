<?php
// var_dump($sales);
?>
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Item Code</th>
                <th>Item Name</th>
                <th>Supplier</th>
                <th>Quantity</th>
                <th>Date Recieved</th>
                <th>Recieved by</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($inventory)) { ?>
                <tr>
                    <td colspan="6" style="text-align: center; color: red; font-wight: bold;">No Data</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($inventory as $key => $value) {
                    ?>
                    <tr>
                        <td><?= $value->item_code ?></td>
                        <td><?= $value->item_name ?></td>
                        <td><?= $value->supplier_name ?></td>
                        <td><?= $value->quantity ?></td>

                        <?php
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $value->date_created);
                        ?>
                        <td><b><?= $date ? $date->format('M d, Y') : 'Invalid Date' ?></b></td>
                        <td><?= $value->recieved_by ?></td>

                    </tr>

                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>

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
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 15,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>