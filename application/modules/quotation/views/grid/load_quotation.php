<?php if($q_list){
    foreach($q_list as $val){
    ?>
    <tr>
        <td><?php echo $val->quotation_no;?></td>
        <td><?= date('F j, Y',  strtotime($val->date_added))?></td>
        <td>
            <button class="btn btn-info btn-sm view_quotation" data-id="<?php echo $val->ID;?>" onclick="view_q(this)"><i class="fas fa-eye"></i></button>
            <button class="btn btn-success btn-sm approve_quotation" data-id="<?php echo $val->ID;?>"><i class="fas fa-check"></i></button>
            <button class="btn btn-danger btn-sm delete_quotation" data-id="<?php echo $val->ID;?>" onclick="delete_q(this)"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }}?>