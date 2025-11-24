<?php
// var_dump($monthly);
if (!empty($monthly)) {
    foreach ($monthly as $key => $value) { ?>
        <tr class="custom-row">
            <td>
                <div data-sales="<?= $value->total ?>"></div>
                <div data-expenses=""></div>
                <div data-profit="<?=$value->total - 0?>"></div>
                <?= date('F', strtotime($value->month_year)) ?>
            </td>
            <td>&#8369 <?= number_format($value->total, 2) ?></td>
            <td></td>
            <td>&#8369 <?=number_format($value->total - 0,2)?></td>
        </tr>
    <?php }
} else {
    ?>
    <tr>
        <td colspan="4">NO DATA</td>
    </tr>
<?php } ?>