<?php
// var_dump($sales);
?>
<!-- <div class="card-body"> -->
<table id="example2" class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>Item Code</th>
            <th>Item Name</th>
            <th>Item Price</th>
            <th>Quantity</th>
            <th>Sub-total</th>
            <th>Discount</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <?php
    $total_sub_total = null;
    $total_discount = null;
    $total_amount = null;
    ?>
    <tbody>
        <?php if (empty($items)) { ?>
            <tr>
                <td colspan="10" style="text-align: center; color: red; font-wight: bold;">No Data</td>
            </tr>
        <?php } else { ?>
            <?php foreach ($items as $value) {
                // var_dump($value);
                $total_sub_total += ($value["unit_price"] * $value["quantity"]);
                $total_discount += $value["discount"];
                $total_amount += (($value["unit_price"] * $value["quantity"]) - $value["discount"]);
                ?>
                <tr>
                    <td><?= $value["item_code"] ?></td>
                    <td><?= $value["item_name"] ?></td>
                    <td><?= "Php " . number_format($value["unit_price"], 2) ?></td>
                    <td><?= $value["quantity"] ?></td>
                    <td><?= "Php " . number_format($value["unit_price"] * $value["quantity"], 2) ?></td>
                    <td><?= "Php " . number_format($value["discount"], 2) ?></td>
                    <td><?= "Php " . number_format(($value["unit_price"] * $value["quantity"]) - $value["discount"], 2) ?></td>
                </tr>

            <?php } ?>
        <?php } ?>
    </tbody>
    <tbody>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td class="text-right"><b style="color: green;">Totals:</b></td>
            <td><b style="color: green;"><?= "Php " . number_format($total_sub_total, 2) ?></b></td>
            <td><b style="color: green;"><?= "Php " . number_format($total_discount, 2) ?></b></td>
            <td><b style="color: green;"><?= "Php " . number_format($total_amount, 2) ?></b></td>
        </tr>
    </tbody>

</table>
<!-- </div> -->

<script>
    $("#example2").DataTable({
        "responsive": false,
        "lengthChange": false,
        "autoWidth": false,
        "ordering": false, // Enable sorting generally
        "columnDefs": [
            { "orderable": false, "targets": [0, 1] } // Disable sorting for the first two columns
        ],
        "searching": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 7,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>