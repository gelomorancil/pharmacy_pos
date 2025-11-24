<?php
// var_dump($sales);
?>
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Item Name</th>
                <th>Sales Sold</th>
            </tr>
        </thead>
        <tbody>
          <?php
            if (!empty($items)) {
                foreach ($items as $key => $value) { ?>
                    <tr class="">
                        <td><b><?= $key + 1?></b></td>
                        <!-- <td><?= $value->item_code ?></td> -->
                        <td><?= $value->item_name ?></td>
                        <td><b style="color: green;"><?= $value->sale_quantity ?></b></td>
                    </tr>
                <?php }
            } else {
                ?>
                <tr>
                    <td class="text-center" colspan="4">NO DATA</td>
                </tr>
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