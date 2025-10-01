<?php load_table_css();?>
<table class="table table-hover text-nowrap datatable">
    <thead>
        <tr>
            <th>Quotation Number</th>
            <th>Total</th>
            <th>Freight</th>
            <th>Date Created</th>
            <th>Date Approved</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if($q_list){
            foreach($q_list as $val){
            ?>
            <tr>
                <td><?php echo $val->quotation_no;?></td>
                <td><?php echo number_format($val->total,2);?></td>
                <td><?php echo number_format($val->freight,2);?></td>
                <td><?= date('F j, Y',  strtotime($val->date_added))?></td>
                <td><?= date('F j, Y',  strtotime($val->date_approved))?></td>
                <td>
                    <button class="btn btn-info btn-sm view_quotation" data-id="<?php echo $val->ID;?>" onclick="view_q(this)"><i class="fas fa-eye"></i></button>
                    <button class="btn btn-success btn-sm approve_quotation" data-id="<?php echo $val->ID;?>" onclick="approve_q(this)"><i class="fas fa-check"></i></button>
                    <button class="btn btn-danger btn-sm delete_quotation" data-id="<?php echo $val->ID;?>" onclick="delete_q(this)"><i class="fas fa-trash"></i></button>
                </td>
            </tr>
        <?php }}?>

    </tbody>
</table>