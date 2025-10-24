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

  /* Change hover color to light gray */
    .select2-results__option--highlighted {
        background-color: #f2f2f2 !important; /* light gray background */
        color: #000 !important; /* black text */
    }

    /* Optional: make the cursor consistent */
    .select2-results__option {
        cursor: pointer;
    }

    .select2-results__options {
        max-height: 400px !important;  /* default is ~200px */
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
            <a class="nav-link" id="preferences-tab" data-toggle="tab" href="#preferences" role="tab">Preferences</a>
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
                    <a class="nav-link active" id="profile-sub-tab" data-toggle="tab" href="#profile-sub" role="tab">Pricing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="items-sub-tab" data-toggle="tab" href="#items-sub" role="tab">Item Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="deleted-sub-tab" data-toggle="tab" href="#deleted-sub" role="tab">Deleted Items</a>
                </li>
            </ul>

            <!-- Sub Tab Content -->
            <div class="tab-content" id="itemSubTabsContent">
                <!-- Pricing tab -->
                 <div class="tab-pane fade show active" id="profile-sub" role="tabpanel">
                    <div class="row">
                        <!-- <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Pricing:</h3>
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
                        </div> -->
                        
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">List of Items:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 45rem;" id="load_items">
                                            <!-- <div class="card-body table-responsive p-0" style="height: 34.3rem;" id="load_item_profiles"> -->
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
                                <!-- Edit Pricing Modal -->
                                <div class="modal fade" id="pricingModal" tabindex="-1" aria-labelledby="pricingModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg"> <!-- modal-lg for wider layout -->
                                        <div class="modal-content">
                                        <div class="modal-header new-color">
                                            <h5 class="modal-title" id="pricingModalLabel">Edit Item Pricing</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <form id="pricingForm">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <strong><h3><span class="" id="item_name_display"></span></h3></strong>
                                                    </div>
                                                </div>
                                                <hr>
                                                <h5 class="text-danger"><strong>Regular Customer Pricing</strong></h5>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="unit_price">Pcs</label>
                                                            <input type="number" id="unit_price" class="form-control inpt" placeholder="Enter Pcs Price">
                                                            <input type="hidden" id="item_profile_id">
                                                        </div>
                                                    </div>
                                                     <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="regular_stub_price">Stub</label>
                                                            <input type="number" id="regular_stub_price" class="form-control inpt" placeholder="Enter Stub Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="regular_box_price">Box</label>
                                                            <input type="number" id="regular_box_price" class="form-control inpt" placeholder="Enter Box Price">
                                                        </div>
                                                    </div>

                                                    <!-- <div class="col-6">
                                                        <div class="form-group w-100">
                                                            <label for="walkin_price">Walk-in Price:</label>
                                                            <input type="number" id="walkin_price" class="form-control inpt" placeholder="Enter Walk-in Price">
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <h5 class="text-danger"><strong>Walkin Customer Pricing</strong></h5>
                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="walkin_price">Pcs</label>
                                                            <input type="number" id="walkin_price" class="form-control inpt" placeholder="Enter Walk-in Price">
                                                        </div>
                                                    </div>
                                                     <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="walkin_stub_price">Stub</label>
                                                            <input type="number" id="walkin_stub_price" class="form-control inpt" placeholder="Enter Stub Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group w-100">
                                                            <label for="walkin_box_price">Box</label>
                                                            <input type="number" id="walkin_box_price" class="form-control inpt" placeholder="Enter Box Price">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <!-- <div class="col-6">
                                                        <div class="form-group w-100">
                                                            <label for="wholesale_price">Wholesale Price:</label>
                                                            <input type="number" id="wholesale_price" class="form-control inpt" placeholder="Enter Wholesale Price">
                                                        </div>
                                                    </div> -->

                                                    <div class="col-6">
                                                        <div class="form-group w-100">
                                                            <label for="threshold">Threshold (in pcs):</label>
                                                            <input type="number" id="threshold" class="form-control inpt" placeholder="Enter Threshold">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-success" id="update_item_profile">Update</button>
                                            </div>
                                        </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item profile Tab -->
                <div class="tab-pane fade" id="items-sub" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">Items Management:</h3>
                                </div>
                                <form>
                                    <div class="card-body">
                                       <div class="row align-items-center">
                                            <div class="col-3">
                                                <label for="Category" class="form-label mb-0">Category:</label>
                                                <select id="Category" class="form-control">
                                                    <option value="" disabled selected>-- Select Category --</option>
                                                    <option value="Generic">Generic</option>
                                                    <option value="Branded">Branded</option>
                                                    <option value="Refreshment">Refreshment</option>
                                                    <option value="J&T">J&T</option>
                                                </select>
                                            </div>
                                                        
                                            <div class="col-auto d-flex gap-2 mt-4">
                                                <button class="btn btn-primary btn-sm mr-2" id="new">New Item</button>
                                                <button class="btn btn-warning btn-sm" id="update_item_2">Update Item</button>
                                            </div>

                                            <div class="col-3 select_item" style="display: none">
                                                <label for="select_item" class="form-label mb-0">Select Items:</label>
                                                <select id="select_item" class="select2 form-control" style="width: 100%;">
                                                    <option value="" disabled selected>-- Select Category --</option>
                                                    <?php foreach($items as $key => $value){ ?>
                                                        <option 
                                                            value="<?= $value->id ?>"
                                                            data-id="<?=$value->id?>" 
                                                            data-item_name="<?=$value->item_name?>" 
                                                            data-item_code="<?=$value->item_code?>" 
                                                            data-short_name="<?=$value->short_name?>" 
                                                            data-description="<?=$value->description?>" 
                                                            data-category="<?=$value->Category?>" 
                                                            data-status="<?=$value->active?>" 
                                                            data-strenght="<?=$value->strenght?>"
                                                            data-packaging="<?=$value->packaging?>"
                                                            data-uom="<?=$value->uom?>"
                                                            data-classification="<?=$value->classification?>"
                                                            data-storage_condition="<?=$value->storage_condition?>"
                                                            data-item_expiry_date="<?=$value->item_expiry_date?>"
                                                            data-batch_no="<?=$value->batch_no?>"
                                                            data-distributor="<?=$value->distributor?>">
                                                            <?= $value->item_name ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>

                                        <hr>
                                        <div id="medicine" style="display: none;">
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
                                                <div class="col-3">
                                                    <div class="form-group w-100">
                                                        <label for="">Manufacturer:</label>
                                                        <input type="text" id="code" class="form-control inpt" placeholder="Manufacturer">
                                                    </div>
                                                </div>
                                                 <div class="col-3">
                                                    <div class="form-group w-100">
                                                        <label for="">Distributor:</label>
                                                        <input type="text" id="distributor" class="form-control inpt" placeholder="Distributor">
                                                    </div>
                                                </div>
                                               
                                            </div>
                                            <div class="row">
                                                 <div class="col-2">
                                                    <div class="form-group w-100">
                                                        <label for="">UOM:</label>
                                                        <select class="form-control" style="width: 100%;" id="uom">
                                                            <option value="" selected disabled>-- Select UOM --</option>
                                                             <?php foreach ($units as $value) { ?>
                                                                <option value="<?= $value->unit_of_measure ?>"><?= $value->unit_of_measure ?></option>
                                                            <?php } ?>
                                                            <!-- <option value="Capsule" >Capsule</option>
                                                            <option value="Tablet">Tablet</option> -->
                                                        </select>
                                                      
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group w-100">
                                                        <label for="">Strenght / Dosage:</label>
                                                        <input type="text" id="strenght" class="form-control inpt"
                                                            placeholder="Strenght / Dosage">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group w-100">
                                                        <label for="">Packaging:</label>
                                                        <input type="text" id="packaging" class="form-control inpt"
                                                            placeholder="Packaging">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <label for="">Classification (Rx/OTC):</label>
                                                    <select name="" id="classification" class="form-control">
                                                        <option value="" disabled selected>-- Select Classification --</option>
                                                        <option value="Rx">Rx</option>
                                                        <option value="OTC">OTC</option>
                                                    </select>
                                                </div>
                                                <!-- <div class="col-3">
                                                    <label for="">Batch No:</label>
                                                    <input type="text" id="batch_no" class="form-control inpt" placeholder="Batch number">
                                                </div>
                                                <div class="col-2">
                                                    <label for="">Expiration Date:</label>
                                                    <input type="date" id="item_expiry_date" class="form-control inpt">
                                                </div> -->
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
                                    </div>
                                    <div class="card-footer">
                                        <button type="button" class="btn btn-primary" id="save_item"  style="display: none">Submit</button>
                                        <button type="button" class="btn btn-warning" style="display: none"
                                            id="update_item">Update</button>
                                        <button type="button" class="btn btn-danger" style="display: none"
                                            id="delete_item">Delete</button>
                                        <button type="button" class="btn btn-default" id="cancel"  style="display: none">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- <div class="col-lg-12 col-md-6 col-sm-12">
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
                        </div> -->
                    </div>
                </div>
                <div class="tab-pane fade" id="deleted-sub" role="tabpanel">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-header new-color">
                                    <h3 class="card-title">List of Deleted Items:</h3>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card m-3">
                                            <div class="card-body table-responsive p-0" style="height: 45rem;" id="load_items_deleted">
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

        <div class="tab-pane fade" id="preferences" role="tabpanel">
        
            <!-- Sub Tabs -->
            <ul class="nav nav-tabs mb-3" id="preferences" role="tablist">
                <li class="nav-item">
                <a class="nav-link active" id="uom-sub-tab" data-toggle="tab" href="#uom-sub" role="tab">Unit of Measure</a>
                </li>
                <li class="nav-item">
                <a class="nav-link" id="supp-sub-tab" data-toggle="tab" href="#supp-sub" role="tab">Supplier</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="client-sub-tab" data-toggle="tab" href="#client-sub" role="tab">Clients</a>
                </li>
            </ul>
            
             <!-- Sub Tab Content -->
            <div class="tab-content" id="preferencesSubTabsContent">
                <!-- UOM Tab -->
                <div class="tab-pane fade show active" id="uom-sub" role="tabpanel">
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
                <!-- Supplier Tab -->
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
                <!-- Client Tab -->
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
    </div>
</div>


</section>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/list/list.js"></script>
<script src="<?php echo base_url() ?>/assets/js/item_profiling/item_profiling.js"></script>
<script>
    $('#select_item').select2({
        width: '100%',
        matcher: function(params, data) {
            if ($.trim(params.term) === '') return data;

            const term = params.term.toLowerCase();
            const text = (data.text || '').toLowerCase();
            let found = text.indexOf(term) > -1;

            if (!found && data.element) {
                const $option = $(data.element);
                $.each($option.data(), function(key, value) {
                    if (String(value).toLowerCase().indexOf(term) > -1) {
                        found = true;
                        return false;
                    }
                });
            }
            return found ? data : null;
        },
        templateResult: function(option) {
            if (!option.id) return option.text;

            const data = $(option.element).data();
            const statusColor = data.status == 1 ? 'green' : 'red';

            return `
                <div class="p-1">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <div>
                            <div class="d-flex align-items-center">
                                <span style="
                                    display:inline-block;
                                    width:10px;
                                    height:10px;
                                    border-radius:50%;
                                    background:${statusColor};
                                    margin-right:6px;
                                "></span>
                                <strong>${data.item_name || option.text}</strong>
                            </div>
                            <small class="text-muted d-block mt-1">
                                <span class="text-danger">GENERIC NAME:</span> ${data.short_name || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">MANUFACTURER:</span> ${data.item_code || '-'}
                            </small>
                            <small class="text-muted d-block">
                                <span class="text-danger">DISTRIBUTOR:</span> ${data.distributor || '-'}
                            </small>
                        </div>
                    </div>

                    <div class="border-top pt-1">
                        <small class="text-muted d-block">
                            <span class="text-primary">CATEGORY:</span> ${data.category || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STRENGTH:</span> ${data.strenght || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">STORAGE:</span> ${data.storage_condition || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">UOM:</span> ${data.uom || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">PACKAGING:</span> ${data.packaging || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">DESCRIPTION:</span> ${data.description || '-'}
                        </small>
                        <small class="text-muted d-block">
                            <span class="text-primary">CLASSIFICATION:</span> ${data.classification || '-'}
                        </small>
                    </div>
                </div>
            `;
        },
        templateSelection: function(option) {
            if (!option.id) return option.text;
            const data = $(option.element).data();
            return data.item_name || option.text;
        },
        escapeMarkup: function(m) { return m; } // Allow HTML rendering
    });

    $(document).on('click', '#new', function() {
        var item_type = $('#Category').val();
      
        if (item_type == 'Generic' || item_type == 'Branded') {
            $('#medicine').show();
            $('#medicine input').attr('required', true);
            $('#medicine select').attr('required', true);
            // $('.card-footer').show();
            $('#update_item_2').hide();
            $('#save_item').show();
            $('#cancel').show();
            $('#update_item').hide();
            $('#delete_item').hide();
            $('#new').hide();

        } else {
            $('#medicine').hide();
            $('#medicine input').attr('required', false);
            $('#medicine select').attr('required', false);
            // $('.card-footer').hide();
            $('#update_item_2').hide();
            $('#new').hide();
        }
    });

    $(document).on('click', '#update_item_2', function(event) {
            // *** ADD THIS LINE TO STOP THE PAGE REFRESH ***
            event.preventDefault(); 
            
            $(this).hide();
            $('#new').hide();
            $('.select_item').show();
    });

    $(document).on('click', '#cancel', function() {
        $('#medicine').hide();
        // $('.card-footer').hide();
        $('#update_item_2').show();
        $('#new').show();
        $('#save_item').hide();
        $('#cancel').hide();
        $('#update_item').hide();
        $('#delete_item').hide();
        $('.select_item').hide();

    });
</script>


