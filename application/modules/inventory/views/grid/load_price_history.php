<table id="" class="table table-bordered table-striped example2">
    <thead>
        <tr>
            <th>Purchase Order #</th>
            <th>RP</th>
            <th>RS</th>
            <th>RB</th>
            <th>WP</th>
            <th>WS</th>
            <th>WB</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $prevCat = '';
        foreach ($history as $key => $value) {
            ?>
            <tr>
                <td>
                    <?= @$value->po_num ?>
                </td>
                <td>
                    <?=@$value->unit_price?>
                </td>
                <td>
                    <?=@$value->regular_stub?>
                </td>
                <td>
                    <?=@$value->regular_box?>
                </td>
                <td>
                    <?=@$value->Walkin_price?>
                </td>
                <td>
                    <?=@$value->walkin_stub?>
                </td>
                <td>
                    <?=@$value->walkin_box?>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
