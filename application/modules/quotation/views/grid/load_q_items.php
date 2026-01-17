    <?php foreach ($items as $key => $val): ?>
        <tr>
            <td><?=$val->item_name?></td>
            <td><?=$val->short_name?></td>
            <td><?=$val->strenght?></td>
            <td><?=$val->packaging?></td>
            <!-- <td><?=date('Y-m-d', strtotime($val->date_expiry))?></td> -->
            <td>
                <?= ($val->date_expiry !== '0000-00-00 00:00:00')
                    ? date('M d, Y', strtotime($val->date_expiry))
                    : '' ?>
            </td>
            <td><?=$val->batch_no?></td>
             <td><?php echo $val->qty; ?></td>
            <td><?php echo number_format($val->supplier_price, 2); ?></td>
            <td><?php echo number_format($val->qty * $val->supplier_price, 2); ?></td>

        </tr>
    <?php endforeach; ?>
