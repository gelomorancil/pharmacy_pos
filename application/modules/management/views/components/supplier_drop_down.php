<div class="row">
    <label for="">Drop Down Preview:</label>
    <select class="form-control" style="width: 100%;">
        <?php
        foreach ($suppliers as $value) {
            ?>
            <option><?= $value->supplier_name ?></option>
            <?php
        }
        ?>
    </select>
</div>