<?php
main_header(['item_profiling']);
$session = (object) get_userdata(USER);

// var_dump($items);
?>
<!-- ############ PAGE START-->
<input hidden id="created_by" value="<?= $session->ID ?>">
<input hidden id="item_profile_id" value="">

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Item Profiling</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Item Profiling</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">

    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">Item Profiling:</h3>
                </div>
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group w-100">
                                    <label for="">Select Item:</label>
                                    <select class="form-control" style="width: 100%;" id="item_id">
                                        <?php
                                        foreach ($items as $value) {
                                            ?>
                                            <option value="<?= $value->id ?>"><?= $value->item_name ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group w-100">
                                    <label for="">Select Unit of Measure:</label>
                                    <select class="form-control" style="width: 100%;" id="unit_id">
                                        <?php
                                        foreach ($units as $value) {
                                            ?>
                                            <option value="<?= $value->id ?>"><?= $value->unit_of_measure ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group w-100">
                                    <label for="">Unit Price:</label>
                                    <input type="number" id="unit_price" class="form-control inpt"
                                        placeholder="Enter Unit Price">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group w-100">
                                    <label for="">Threshold:</label>
                                    <input type="number" id="threshold" class="form-control inpt"
                                        placeholder="Enter Threshold">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-primary" id="save_item_profile">Submit</button>
                        <button type="button" class="btn btn-success" style="display: none"
                            id="update_item_profile">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="card card-gray-dark">
                <div class="card-header">
                    <h3 class="card-title">Current Item Profiles:</h3>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card m-3">
                            <div class="card-body table-responsive p-0" style="height: 34.3rem;">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>Item Name</th>
                                            <th>Unit</th>
                                            <th>Unit Price</th>
                                            <th>Threshold</th>
                                        </tr>
                                    </thead>
                                    <tbody id="load_item_profiles">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/item_profiling/item_profiling.js"></script>