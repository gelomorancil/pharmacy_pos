<?php
main_header(['list_management']);
?>
<!-- ############ PAGE START-->
<!-- HIDDEN ID's USED AS UPDATE FLAGS -->
<!-- <input hidden value="" id="item_id"> -->
<input hidden value="" id="supplier_id">
<!-- <input hidden value="" id="unit_id"> -->
<input hidden value="" id="client_id">
<input hidden value="" id="item_profile_id">

<style>
  /* Scoped only to Management page */
  .management-page .nav-tabs .nav-link,
  .management-page .nav-pills .nav-link {
    color: #000 !important;      
    background: transparent !important; 
    border: none !important;     
  }

  .management-page .nav-tabs .nav-link.active,
  .management-page .nav-pills .nav-link.active {
    font-weight: 600;
    border-bottom: 3px solid #035863 !important;
    color: #000 !important;
  }
</style>


<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Management</h1>
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

<div class="container-fluid mt-4 management-page">
  <!-- Main Tabs -->
    <ul class="nav nav-tabs" id="managementTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="items-tab" data-toggle="tab" href="#items" role="tab">Item Management</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="accounts-tab" data-toggle="tab" href="#accounts" role="tab">User Accounts</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="settings-tab" data-toggle="tab" href="#settings" role="tab">Store Settings</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="managementTabsContent">
        <!-- Items Tab -->
        <div class="tab-pane fade show active" id="items" role="tabpanel">
        
            <!-- Sub Tabs -->
            <ul class="nav nav-tabs mb-3" id="itemSubTabs" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="profile-sub-tab" data-toggle="tab" href="#profile-sub" role="tab">Items</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="items-sub-tab" data-toggle="tab" href="#items-sub" role="tab">Item Profile</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="uom-sub-tab" data-toggle="tab" href="#uom-sub" role="tab">Unit of Measure</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="supp-sub-tab" data-toggle="tab" href="#supp-sub" role="tab">Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="client-sub-tab" data-toggle="tab" href="#client-sub" role="tab">Clients</a>
                </li>
            </ul>

            <!-- Sub Tab Content -->
            <div class="tab-content" id="itemSubTabsContent">
                 <div class="tab-pane fade show active" id="profile-sub" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
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
                                                    <label for="">Regular Price:</label>
                                                    <input type="number" id="unit_price" class="form-control inpt"
                                                        placeholder="Enter Regular Price">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">Walk-in Price:</label>
                                                    <input type="number" id="walkin_price" class="form-control inpt"
                                                        placeholder="Enter Walkin Price">
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row">
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">Wholesale Price:</label>
                                                    <input type="number" id="wholesale_price" class="form-control inpt"
                                                        placeholder="Enter Wholesale Price">
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
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Current Item Profiles:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 34.3rem;" id="load_item_profiles">
                                                <!-- <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Brand Name</th>
                                                            <th>Unit</th>
                                                            <th>Unit Price</th>
                                                            <th>Walkin Price</th>
                                                            <th>Wholesale Price</th>
                                                            <th>Threshold</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_item_profiles">

                                                    </tbody>
                                                </table> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="uom-sub" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
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
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Current Units:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <!-- <div class="card m-3">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <div id="unit_drop_down"></div>
                                                </h3>
                                            </div>
                                        </div> -->
                                    </div>
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 12rem;"  id="load_units">
                                                <!-- <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_units">

                                                    </tbody>
                                                </table> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="items-sub" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Items Management:</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group w-100">
                                                    <label for="">Brand Name:</label>
                                                    <input type="text" id="item_name" class="form-control inpt"
                                                        placeholder="Brand Name">
                                                </div>
                                            </div>
                                             <div class="col-3">
                                                <div class="form-group w-100">
                                                    <label for="">Generic Name:</label>
                                                    <input type="text" id="short_name" class="form-control inpt"
                                                        placeholder="Item Generic Name">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <div class="form-group w-100">
                                                    <label for="">Code:</label>
                                                    <input type="text" id="code" class="form-control inpt" placeholder="Item Code">
                                                </div>
                                            </div>
                                             <div class="col-2">
                                                 <div class="form-group w-100">
                                                    <label for="">UOM:</label>
                                                     <select class="form-control" style="width: 100%;" id="uom">
                                                        <option value="" selected disabled>-- Select UOM --</option>
                                                        <option value="Capsule" >Capsule</option>
                                                        <option value="Tablet">Tablet</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                 <div class="form-group w-100">
                                                    <label for="">Strenght / Dosage:</label>
                                                     <input type="text" id="strenght" class="form-control inpt"
                                                        placeholder="Strenght / Dosage">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group w-100">
                                                    <label for="">Packaging:</label>
                                                    <input type="text" id="packaging" class="form-control inpt"
                                                        placeholder="Packaging">
                                                </div>
                                            </div>
                                           
                                            <div class="col-2">
                                                <label for="">Category:</label>
                                                <select name="" id="Category" class="form-control">
                                                    <option value="" disabled selected>-- Select Category --</option>
                                                    <option value="Generic">Generic</option>
                                                    <option value="Branded">Branded</option>
                                                    <option value="Refreshment">Refreshment</option>
                                                    <option value="J&T">J&T</option>
                                                </select>
                                            </div>
                                           
                                            <div class="col-2">
                                                <label for="">Classification (Rx/OTC):</label>
                                                <select name="" id="classification" class="form-control">
                                                    <option value="" disabled selected>-- Select Classification --</option>
                                                    <option value="Rx">Rx</option>
                                                    <option value="OTC">OTC</option>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="">Batch No:</label>
                                                <input type="text" id="batch_no" class="form-control inpt" placeholder="Batch number">
                                            </div>
                                            <div class="col-2">
                                                <label for="">Expiration Date:</label>
                                                <input type="date" id="item_expiry_date" class="form-control inpt">
                                            </div>
                                        </div>
                                         <div class="row">
                                             <div class="col-5">
                                                <label for="">Indication / Category:</label>
                                                <textarea id="item_description" class="form-control" rows="3"
                                                    placeholder="Item Description"></textarea>
                                            </div>
                                            <div class="col-5">
                                                <label for="">Storage Condition:</label>
                                                <textarea id="storage_condition" class="form-control" rows="3"
                                                    placeholder="Storage Condition"></textarea>
                                            </div>
                                             <div class="col-2">
                                                <label for="">Status:</label>
                                                <select class="form-control" style="width: 100%;" id="item_status">
                                                    <option value="1" selected>Active</option>
                                                    <option value="0">In-active</option>
                                                </select>
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
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Current Items:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 50rem;" id="load_items">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="supp-sub" role="tabpanel">
                     <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
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
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Current Suppliers:</h3>
                                </div>

                                <div class="row">
                                    <!-- <div class="col-4">
                                        <div class="card m-3">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <div id="supplier_drop_down"></div>
                                                </h3>
                                            </div>
                                        </div>
                                    </div> -->
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 34.3rem;" id="load_suppliers">
                                                <!-- <table class="table table-hover text-nowrap">
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
                                                </table> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="client-sub" role="tabpanel">
                     <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Client Management:</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group w-100">
                                                    <label for="">Client Name:</label>
                                                    <input type="text" id="client-name" class="form-control inpt"
                                                        placeholder="Enter Client Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group w-100">
                                                    <label for="">Company Affliated:</label>
                                                    <textarea id="client-company-aff" class="form-control"
                                                        placeholder="Enter Client Affliate"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group w-100">
                                                    <label for="">Contact Number</label>
                                                    <input type="text" id="client-cn" class="form-control inpt"
                                                        placeholder="Enter Contact Number">
                                                </div>
                                            </div>
                                            <div class="col-8">
                                                <div class="form-group w-100">
                                                    <label for="">Email:</label>
                                                    <input type="email" id="client-email" class="form-control inpt"
                                                        placeholder="Enter Client Email">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-8">
                                                <div class="form-group w-100">
                                                    <label for="">LTO Number:</label>
                                                    <input type="text" id="client-lto" class="form-control inpt"
                                                        placeholder="Enter LTO Number">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group w-100">
                                                    <label for="">Status:</label>
                                                    <select class="form-control" style="width: 100%;" id="client_status">
                                                        <option value="1" selected>Active</option>
                                                        <option value="0">In-active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary" id="save_client">Submit</button>
                                        <button type="button" class="btn btn-success" style="display: none"
                                            id="update_client">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-8 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Current Clients:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 34.3rem;" id="load_clients">
                                                <!-- <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Client Name</th>
                                                            <th>Contact Number</th>
                                                            <th>LTO Number</th>
                                                            <th>Email Address</th>
                                                            <th>Company Affiliate</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_clients">
                                                    </tbody>
                                                </table> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <div class="tab-pane fade" id="accounts" role="tabpanel">
        
            <!-- Sub Tabs -->
            <ul class="nav nav-tabs mb-3" id="accounts" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="accounts-sub-tab" data-toggle="tab" href="#accounts-sub" role="tab">User Accounts</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="items-sub-tab" data-toggle="tab" href="#items-sub" role="tab">Role Based Access Control</a>
                </li>
            </ul>

            <!-- Sub Tab Content -->
            <div class="tab-content" id="accountsubTabsContent">
                <div class="tab-pane fade show active" id="accounts-sub" role="tabpanel">
                <!-- your table + search + button here -->
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <!-- NEW CUSTOMER -->
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">New User</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">Last Name</label>
                                                    <input type="text" id="LName" class="form-control inpt" placeholder="Last Name">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">First Name</label>
                                                    <input type="text" id="FName" class="form-control inpt"
                                                        placeholder="First Name">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">Username</label>
                                                    <input type="text" id="UName" class="form-control inpt" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">User Role</label>
                                                    <select class="form-control" style="width: 100%;" id="Role">
                                                        <?php
                                                        foreach ($user_role as $key => $value) { ?>
                                                            <option data-id="<?= $value->id ?>" data-role="<?= $value->user_role ?>">
                                                                <?= $value->user_role ?>
                                                            </option>
                                                        <?php }

                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="row">
                                            <div class="col-6">
                                                <div class="form-group w-100">
                                                    <label for="">Branch</label>
                                                    <select class="form-control" style="width: 100%;" id="Branch">
                                                        <?php
                                                        if (!empty($session->Branch)) { ?>
                                                            <option value="<?= $session->Branch ?>"><?= $session->Branch ?></option>
                                                        <?php } else {
                                                            foreach ($branch as $key => $value) { ?>
                                                                <option value="<?= $value->List_name ?>"><?= $value->List_name ?></option>
                                                            <?php }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                &nbsp;
                                            </div>
                                        </div> -->

                                        <small>Default Password: <cite>Password1234</cite></small>

                                    </div>
                                    
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#modal-default" id="Save">Submit</button>
                                        <button type="button" class="btn btn-warning" id="Update" value=""
                                            style="display:none">Update</button>
                                        <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#r_modal-default" id="Reset" value="" style="display:none">Reset
                                            Password</button>
                                        <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#d_modal-default" id="Delete" value="" style="display:none">Delete
                                            User</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">User lists</h3>
                                </div>
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 280px;"  id="load_user">
                                                <!-- <table class="table table-hover text-nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Username</th>
                                                            <th>Role</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="load_user">

                                                    </tbody>
                                                </table> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="items-sub" role="tabpanel">
                <!-- categories content -->
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
<script src="<?php echo base_url() ?>/assets/js/item_profiling/item_profiling.js"></script>