<div class="row">
    <label for="">Drop Down Preview:</label>
    <select class="form-control" style="width: 100%;">
        <?php
        foreach ($units as $value) {
            ?>
            <option><?= $value->unit_of_measure ?></option>
            <?php
        }
        ?>
    </select>
</div>