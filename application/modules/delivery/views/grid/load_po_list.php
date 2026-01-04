<table id="example10" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Purchase Order</th>
            <th>Date Added</th>
            <th>Date Approved</th>
            <th>Supplier</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($purchase_order as $key => $value) {
            ?>
            <tr>

                <td class="text-center" style="color: red; font-weight: bolder;">PO-<?= $value->po_num ?></td>
                <td class="text-center"><?=  date('Y-m-d',strtotime(@$value->date_added ))?></td>
                 <td class="text-center"><?= $value->date_approved != '0000-00-00 00:00:00'
                        ? date('Y-m-d', strtotime($value->date_approved))
                        : '-';
                    ?>
                    </td>
                <td class="text-center"><?= @$value->supplier_name??"<span style='color:red;font-weight:bold;'>UPDATE TO ADD SUPPLIER</span>"?></td>
                <td class="text-center">

                    <!-- Approve Button -->
                     
                    <?php if($value->approved == 1){ ?>
                        <button type="button" 
                            class="btn btn-sm btn-primary"
                            data-PO="<?= $value->po_num ?>" 
                            onclick="view_delivery(this)">
                        <i class="fa fa-eye"></i> Approved
                        </button>
                    <?php } else {?>
                    <button type="button" 
                            class="btn btn-sm btn-success" 
                            data-PO="<?= $value->po_num ?>" 
                            onclick="approve_delivery(this)">
                        <i class="fa fa-check"></i> Approve Delivery
                    </button>
                    <?php } ?>
                </td>

            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script>
    $("#example10").DataTable({
        // "responsive": false,
        "lengthChange": false,
        // "autoWidth": false,
        // "buttons": ["copy", "csv", "excel", "pdf", "print"],
        "pageLength": 15,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
</script>