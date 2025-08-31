<table id="example10" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th style="width:10%;">Purchase Order</th>
            <th style="width:75%;">Items Listed</th>
            <th style="width:15%;">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($purchase_order as $key => $value) {
            ?>
            <tr>

                <td class="text-center" style="color: red; font-weight: bolder;">PO-<?= $value->po_num ?></td>
                <td class="text-center"><?= @$value->description ?></td>
                <td class="text-center">
                    <!-- Edit Button -->
                    <button type="button" 
                            class="btn btn-sm btn-primary" 
                            data-PO="<?= $value->po_num ?>" 
                            onclick="edit_po(this)">
                        <i class="fa fa-edit"></i>
                    </button>

                    <!-- Delete Button -->
                    <button type="button" 
                            class="btn btn-sm btn-danger" 
                            data-PO="<?= $value->po_num ?>" 
                            onclick="del_po(this)">
                        <i class="fa fa-trash"></i>
                    </button>

                    <!-- Approve Button -->
                    <button type="button" 
                            class="btn btn-sm btn-success" 
                            data-PO="<?= $value->po_num ?>" 
                            onclick="approve_po(this)">
                        <i class="fa fa-check"></i>
                    </button>
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