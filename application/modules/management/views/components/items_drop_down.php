<div class="row">
    <label for="">Drop Down Preview:</label>
    <select class="form-control" style="width: 100%;">
        <?php
        foreach ($items as $value) {
            ?>
            <option><?= $value->item_name ?></option>
            <?php
        }
        ?>
    </select>
</div>