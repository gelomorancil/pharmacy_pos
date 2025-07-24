<?php
main_header(['list_management']);
?>
<!-- ############ PAGE START-->
<!-- HIDDEN ID's USED AS UPDATE FLAGS -->
<input hidden value="" id="item_id">
<input hidden value="" id="supplier_id">
<input hidden value="" id="unit_id">


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">List Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">List Management</a></li>
                    <li class="breadcrumb-item active">Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Unit Management:</h3>
                    </div>
                    <form>
                        <div class="card-body" style="height: 10.1rem;">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="">Unit:</label>
                                        <input type="text" id="unit" class="form-control inpt" placeholder="Enter Unit">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" id="save_unit">Submit</button>
                            <button type="button" class="btn btn-danger" id="delete_unit" style="display: none">Delete</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="card card-purple">
                    <div class="card-header">
                        <h3 class="card-title">Current Units:</h3>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="card m-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <div id="unit_drop_down"></div>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card m-3">
                                <div class="card-body table-responsive p-0" style="height: 12rem;">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Unit</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_units">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Item List Management -->
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Items Management:</h3>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group w-100">
                                        <label for="">Item Name:</label>
                                        <input type="text" id="item_name" class="form-control inpt"
                                            placeholder="Item Name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group w-100">
                                        <label for="">Code:</label>
                                        <input type="text" id="code" class="form-control inpt" placeholder="Item Code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group w-100">
                                        <label for="">Short Name:</label>
                                        <input type="text" id="short_name" class="form-control inpt"
                                            placeholder="Item Short Name">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group w-100">
                                        <label for="">Status:</label>
                                        <select class="form-control" style="width: 100%;" id="item_status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">In-active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="">Description:</label>
                                    <textarea id="item_description" class="form-control" rows="3"
                                        placeholder="Item Description"></textarea>
                                </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" id="save_item">Submit</button>
                            <button type="button" class="btn btn-success" style="display: none"
                                id="update_item">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Current Items:</h3>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="card m-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <div id="items_drop_down"></div>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card m-3">
                                <div class="card-body table-responsive p-0" style="height: 22.6rem;">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Item Name</th>
                                                <th>Item Code</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_items">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Supplier Management:</h3>
                    </div>
                    <form>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="">Supplier Name:</label>
                                        <input type="text" id="supplier_name" class="form-control inpt"
                                            placeholder="Enter Supplier Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="">Supplier Address:</label>
                                        <textarea id="supplier_address" class="form-control" rows="3"
                                            placeholder="Enter Supplier Address"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group w-100">
                                        <label for="">Contact Person:</label>
                                        <input type="text" id="contact_person" class="form-control inpt"
                                            placeholder="Enter Contact Person">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="">Contact Number 1:</label>
                                        <input type="text" id="cn_1" class="form-control inpt"
                                            placeholder="Enter Contact Number">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group w-100">
                                        <label for="">Contact Number 2:</label>
                                        <input type="text" id="cn_2" class="form-control inpt"
                                            placeholder="Enter Contact Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="form-group w-100">
                                        <label for="">Email:</label>
                                        <input type="email" id="supplier_email" class="form-control inpt"
                                            placeholder="Enter Email">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group w-100">
                                        <label for="">Status:</label>
                                        <select class="form-control" style="width: 100%;" id="supplier_status">
                                            <option value="1" selected>Active</option>
                                            <option value="0">In-active</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="button" class="btn btn-primary" id="save_supplier">Submit</button>
                            <button type="button" class="btn btn-success" style="display: none"
                                id="update_supplier">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 col-sm-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Current Suppliers:</h3>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="card m-3">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <div id="supplier_drop_down"></div>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card m-3">
                                <div class="card-body table-responsive p-0" style="height: 34.3rem;">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Supplier Name</th>
                                                <th>Contact Person</th>
                                                <th>Contact Number</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody id="load_suppliers">

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
<script src="<?php echo base_url() ?>/assets/js/list/list.js"></script>