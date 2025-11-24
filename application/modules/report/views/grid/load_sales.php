<?php
// var_dump($sales);
?>
<div class="card-body">
    <table id="example1" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <!-- <th>Sub-total</th> -->
                <th>Discount</th>
                <th>Discount Type</th>
                <th>Total Amount</th>
                <th>Payment Type</th>
                <th>Reference Number</th>
                <th>Series Number</th>
                <th>Remarks</th>
                <th>Recieved By</th>
                <th>Status</th>
                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <?php
        $total_sales = null;
        ?>
        <tbody>
            <?php if (empty($sales)) { ?>
                <tr>
                    <td colspan="11" style="text-align: center; color: red; font-wight: bold;">No Data</td>
                </tr>
            <?php } else { ?>
                <?php foreach ($sales as $key => $value) {
                    // var_dump($value['control_number']);
                    if($value['voided'] == 0){
                        $total_sales = $total_sales + $value['total_amount'];
                    }
                    ?>
                    <tr onclick="show_individual_items(this)" 
                        data-children-array='<?= json_encode($value['children']) ?>'<?= count($value['children']) ?>
                        data-parent_id="<?=$value['id']?>"
                        data-sub_total="<?=$value['sub_total']?>"
                        data-discount="<?=$value['discount_amount']?>"
                        data-total_amount="<?=$value['total_amount']?>"
                        data-discount_type="<?=$value['discount_type']?>"
                        data-payment_type="<?=$value['payment_type']?>"
                        data-control_number="<?=$value['control_number']?>"
                        data-date_created="<?=$value['date_created']?>"

                    >
                        <?php
                        $date = DateTime::createFromFormat('Y-m-d H:i:s', $value['date_created']);
                        ?>
                        <td><b><?= $date ? $date->format('M d, Y') : 'Invalid Date' ?></b></td>
                        <td><?= $value['buyer_name'] ?></td>
                        <!-- <td><?= 'Php ' . number_format($value['sub_total'], 2) ?></td> -->
                        <td><?= 'Php ' . number_format($value['discount_amount'], 2) ?></td>
                        <td><?= $value['discount_type'] ?></td>
                        <td><b style="color:green;"><?= 'Php ' . number_format($value['total_amount'], 2) ?></b></td>
                        <td><?= $value['payment_type'] ?></td>
                        <td><?= $value['reference_number'] ?></td>
                        <td><?= $value['control_number'] ?></td>
                        <td><?= $value['remarks'] ?></td>
                        <td><?= $value['LName'] ?>, <?= $value['FName'] ?></td>
                        <td><?= $value['voided'] == 1 ? '<b style="color: red;">VOIDED<b/>' : '<b style="color: green;">ACTIVE<b/>' ?></td>

                    </tr>

                <?php } ?>
            <?php } ?>
        </tbody>
        <tbody>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td class="text-right" style="background-color:#1FDA3D;"><b style="color:black;">Total Sales Amount:</b></td>
                <td style="background-color:#1FDA3D;"><b style="color:black;"><?= 'Php ' . number_format($total_sales, 2) ?></b></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    $("#example1").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false, // Enable sorting generally
        "columnDefs": [
            { "orderable": false, "targets": [0, 1] } // Disable sorting for the first two columns
        ],
        "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 15,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>