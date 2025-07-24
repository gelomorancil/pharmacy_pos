<?php
main_header(['user_management']);
$session = (object) get_userdata(USER);
// var_dump($user_role);

?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">User Management</a></li>
                    <li class="breadcrumb-item active">Management</li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12">
                <!-- NEW CUSTOMER -->
                <div class="card card-gray-dark">
                    <div class="card-header">
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
                <div class="card card-gray-dark">
                    <div class="card-header">
                        <h3 class="card-title">User lists</h3>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 280px;">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody id="load_user">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- CONFIRMATION MODAL -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to save details?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div> -->
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="save_user">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- RESET CONFIRMATION MODAL -->
<div class="modal fade" id="r_modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to reset this user's password?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div> -->
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="reset_pass" value="">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal fade" id="d_modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Are you sure you want to delete this user?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- <div class="modal-body">
                <p>One fine body&hellip;</p>
            </div> -->
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="delete_user" value="">Yes</button>
            </div>
        </div>
    </div>
</div>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/list/list.js"></script>