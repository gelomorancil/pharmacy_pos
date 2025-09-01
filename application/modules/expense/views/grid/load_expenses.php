<div class="card-body table-responsive">
    <table id="example1" class="table table-hover text-nowrap table-sm table-striped text-center" style="font-size: 10pt;">
        <!-- <span style="font-style:italic"><strong>Note: Click row to preview proof of payment</strong></span> -->
        
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Description</th>
                <th>Incharge</th>
                <th>Actual Money</th>
                <th>Actual Expenses</th>
                <th>Balance</th>
                <th>Action</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $session = (object)get_userdata(USER);

            if (!empty($expenses)) {
                $total_act = 0;
                $total_exp = 0;
                foreach ($expenses as $key => $value) {
                        // $d_date = date('Y-m-d',strtotime($value->Deadline));
                        // $clickableClass = ($value->Mode == 'online payment') ? 'clickable-row' : '';
                        $total_act += $value->Actual_Money;
                        $total_exp += $value->expense;
                    ?>
                        <tr>
                            <td><?= $key+1 ?></td>
                            <td><?= date('M d, Y', strtotime(@$value->Date)) ?></td>
                            <td class="text-wrap"><?= ucfirst(@$value->Descr) ?></td>
                            <td class="text-wrap"><?= @$value->FName." ".@$value->LName ?></td>
                            <td><?= number_format(@$value->Actual_Money,2) ?></td>
                            <td><?= number_format(@$value->expense,2) ?></td>
                            <td><?=number_format(@$value->Balance,2) ?></td>
                            <td>
                                <button class=" btn-primary btn-xs edit_exp" value="<?=$value->ID?>"><i class="fa fa-pencil-alt"></i></button>
                                <button class=" btn-success btn-xs clickable-row"  data-toggle="modal" data-target="#paymentProofModal" data-img="<?= $value->Image ?>"><i class="fa fa-eye"></i></button>
                                <button class="btn btn-xs btn-danger btn_void_exp" value="<?=$value->ID?>">Void</button>
                            </td>
                        </tr>
                
                    <?php
                } ?>

                
            <?php } else { ?>
                <tr>
                    <td colspan="9">
                        <div>
                            <center>
                                <h6>No data available in table.</h6>
                            </center>
                        </div>
                    </td>
                </tr>
            <?php }
            ?>
        </tbody>
        <tr>                     
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td class="text-bold text-danger"><?= @number_format(@$total_act,2)?></td>
        <td class="text-bold text-danger"><?= @number_format(@$total_exp,2)?></td>
        <td class="text-bold text-danger"><?= @number_format(@$total_act - $total_exp,2)?></td>
        <td></td>
    </tr>
    </table>
   
</div>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": false, 
      "lengthChange": false, 
      "autoWidth": false,
      "pageLength":50,
      "buttons": (<?= json_encode($session->Role == "Admin")?> ? ["excel", "pdf", "print"] : [])
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>