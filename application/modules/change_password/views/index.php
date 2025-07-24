<?php

login_header();
// var_dump($username)
?>
<div class="login-box">
  <div class="login-logo">
    <a href="../../index2.html"><b>Change password</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <div>
        <label>Username:</label>
        <div class="input-group mb-3">
          <input type="text" disabled class="form-control" id="username" placeholder="Username" required autofocus value="<?=$username?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
      </div>

      <div>
        <label>Enter Current Password:</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="current_pass" placeholder="Current Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      </div>

      <div>
        <label>Enter New Password:</label>
        <div class="input-group mb-3">
          <input type="password" class="form-control" id="new_pass" placeholder="New Password" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <button type="button" id="change_password" class="btn btn-success btn-block">Change Password</button>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
login_footer();
?>

<script src="<?php echo base_url() ?>/assets/js/change_password/change_password.js"></script>