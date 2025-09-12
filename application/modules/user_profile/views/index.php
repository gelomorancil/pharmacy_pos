<?php
main_header(['']);
?>
<!-- ############ PAGE START-->
<style>
.profile-img-container {
    position: relative;
    width: 120px;
    height: 120px;
}

.profile-img-container img {
    width: 120px;
    height: 120px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #ddd;
}

/* Overlay for edit button */
.profile-img-container .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 120px;
    height: 120px;
    border-radius: 50%;
    background: rgba(0,0,0,0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
    color: #fff;
    font-size: 22px;
}

.profile-img-container:hover .overlay {
    opacity: 1;
}


</style>
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
                        <!-- Profile Image -->
                        <div class="text-center d-flex justify-content-center position-relative">
                            <div class="profile-img-container">
                                <img id="profileImage" 
                                    class="profile-user-img img-fluid img-circle"
                                    src="<?= !empty($image) ? base_url().'/assets/images/Users/'.$image : base_url().'/assets/images/Users/default-avatar.avif' ?>"
                                    alt="User profile picture">

                                <!-- Overlay with edit button -->
                                <div class="overlay" onclick="document.getElementById('fileInput').click();">
                                    <i class="fas fa-edit"></i>
                                </div>

                                <!-- Hidden file input -->
                                <input type="file" id="fileInput" style="display:none;" accept="image/*">
                            </div>
                        </div>

                        <!-- Update button (hidden initially) -->
                        <div class="text-center mt-2">
                            <button type="button" id="updateProfileBtn" class="btn btn-sm btn-primary" style="display:none;">
                                <i class="fas fa-pen"></i> Update Image
                            </button>
                        </div>


                        <!-- Name & Role -->
                        <h3 class="profile-username text-center">
                            <?= ucfirst($session->FName)." ".ucfirst($session->LName) ?>
                        </h3>
                        <p class="text-muted text-center"><?= ucfirst($session->Role) ?></p>

                        <!-- Details -->
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Username</b> <a class="float-right"><?=$session->Username?></a><input type="text" class="float-right" id="uname" value="<?=$session->Username?>" style="display: none;">
                            </li>
                            <!-- <li class="list-group-item">
                                <b>Email</b> <a class="float-right"><?= $session->Email ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Contact</b> <a class="float-right"><?= $session->Contact ?? 'N/A' ?></a>
                            </li>
                            <li class="list-group-item">
                                <b>Last Login</b> <a class="float-right"><?= $session->LastLogin ?? '—' ?></a>
                            </li> -->
                            
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

                        <!-- Action Buttons -->
                        <button type="button" class="btn btn-primary btn-block" id="reset_password"><b>Reset Password</b></button>
                        <button type="button" class="btn btn-success btn-block" id="Login"><b>Enter</b></button>
                        <button type="button" class="btn btn-danger btn-block" id="Cancel"><b>Cancel</b></button>
                        <button type="button" class="btn btn-warning btn-block" id="Change"><b>Change</b></button>
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
<script>
document.getElementById("fileInput").addEventListener("change", function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update preview
            document.getElementById("profileImage").src = e.target.result;

            // Show update button
            document.getElementById("updateProfileBtn").style.display = "inline-block";
        };
        reader.readAsDataURL(file);
    }
});

// Optional: handle update button click
document.getElementById("updateProfileBtn").addEventListener("click", function() {

    let formData = new FormData();
    let file = $("#fileInput")[0].files[0];

    if (!file) {
        alert("Please choose a file first.");
        return;
    }

    formData.append("fileInput", file);

    $.ajax({
        url: base_url + "user_profile/service/User_profile_service/update_profile_image",
        type: "POST",
        data: formData,
        contentType: false, // required
        processData: false, // required
        success: function(response) {
            let res = JSON.parse(response);
            if (!res.has_error) {
                // update the image without re-login
                $('#profileImage').attr('src', base_url + 'assets/images/Users/' + res.new_image);
                toastr.success("Profile image updated!");
            } else {
                toastr.error(res.message);
            }
        }
    });
});


</script>