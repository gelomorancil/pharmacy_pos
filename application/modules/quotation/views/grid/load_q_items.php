    <?php foreach ($items as $key => $val): ?>
        <tr>
            <!-- Qty -->
            <td><?php echo $key+1; ?></td>

            <!-- Item (e.g., item name / product reference) -->
            <td><?php echo $val->item_name; ?></td>

            <!-- Unit of Measure -->
            <td><?php echo $val->unit_of_measure; ?></td>

            <!-- Item Description -->
            <td><?php echo $val->po_descr; ?></td>

            <!-- Pcs -->
            <td><?php echo $val->pcs; ?></td>

            <!-- Unit Price -->
            <td><?php echo number_format($val->unit_price, 2); ?></td>

            <!-- Total -->
            <td><?php echo number_format($val->qty * $val->unit_price, 2); ?></td>

        </tr>
    <?php endforeach; ?>
