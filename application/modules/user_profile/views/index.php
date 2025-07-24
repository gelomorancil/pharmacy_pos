<?php
main_header(['']);
?>
<!-- ############ PAGE START-->

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User Profile</h1>
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
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <!-- <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                            src="../../dist/img/user4-128x128.jpg"
                            alt="User profile picture">
                        </div> -->

                        <h3 class="profile-username text-center"><?=ucfirst($session->FName)." ".ucfirst($session->LName)?></h3>

                        <p class="text-muted text-center"><?=ucfirst($session->Role)?></p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right"><?=$session->Username?></a><input type="text" class="float-right" id="uname" value="<?=$session->Username?>" style="display: none;">
                            </li>
                             <li class="list-group-item text-center" id="c_pass" style="display: none;">
                                <label class="text-danger" for="">Change Password</label>
                                <input type="password" id="pass" class="form-control inpt" placeholder="Enter Old Password">   
                            </li>
                            <li class="list-group-item text-center n_pass"  style="display: none;">
                                <input type="password" id="new_pass" class="form-control inpt" placeholder="Enter New Password">   
                            </li>
                            <li class="list-group-item text-center n_pass"  style="display: none;">
                                <input type="password" id="r_new_pass" class="form-control inpt" placeholder="Re-enter New Password">   
                            </li>
                            
                           
                        </ul>

                        <button type="button" class="btn btn-primary btn-block" id="reset_password"><b>Reset Password</b></a>
                        <button type="button" class="btn btn-success btn-block" id="Login"><b>Enter</b></a>
                        <button type="button" class="btn btn-danger btn-block" id="Cancel"><b>Cancel</b></a>
                        <button type="button" class="btn btn-warning btn-block" id="Change"><b>Change</b></a>

                    </div>
                </div>
            </div>
            <!-- <div class="col-lg-9 col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Lists</h3>
                    </div>

                    <div class="card-body table-responsive p-0" style="height: 280px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th>List Category</th>
                                    <th>List Name</th>
                                </tr>
                            </thead>
                            <tbody id="load_list">
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> -->
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
                <button type="button" class="btn btn-primary" id="save_list">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- ############ PAGE END-->
<?php
main_footer();
?>
<script src="<?php echo base_url() ?>/assets/js/user/user.js"></script>