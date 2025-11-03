<?php
// var_dump($sales);
?>
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Buyer Name</th>
                <th>Total Purchases</th>
            </tr>
        </thead>
        <tbody>
           <?php
            if (!empty($buyers)) {
                foreach ($buyers as $key => $value) { ?>
                    <tr class="">
                        <td><b><?= $key + 1?></b></td>
                        <td><?= $value->buyer_name ?></td>
                        <td><b style="color: green;">&#8369 <?= number_format($value->sale_quantity,2)?></b></td>
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