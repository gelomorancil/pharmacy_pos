<?php

login_header();
?>
<style>
  body {
    background-color: #ffffff;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .login-box {
    width: 100%;
    max-width: 950px;
    margin: 60px auto;
  }

  .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.1);
    overflow: hidden;
  }

  .login-left {
    background: #fff;
    display: flex;
    align-items: center;
  }

  .login-left .inner-container {
    width: 100%;
    padding: 40px 35px;
  }

  .login-logo a {
    color: #035863;
    font-weight: bold;
    font-size: 28px;
    text-decoration: none;
  }

  .form-control {
    border-radius: 8px;
  }

  .input-group-text {
    background-color: #f5f5f5;
    border-radius: 0 8px 8px 0;
    color: #035863;
  }

  .btn-primary {
    background-color: #035863;
    border-color: #035863;
    border-radius: 8px;
    padding: 10px;
    font-size: 16px;
  }

  .btn-primary:hover {
    background-color: #024654;
    border-color: #024654;
  }

  .login-box-msg {
    color: #555;
    font-size: 15px;
    margin-bottom: 25px;
  }

  .login-right {
    background-color: #035863;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    padding: 30px;
  }

  .login-right img {
    max-width: 85%;
    height: auto;
  }
</style>

<div class="login-box">
  <div class="card">
    <div class="row no-gutters">
      
      <!-- Left Side - Login Form -->
      <div class="col-md-6 login-left">
        <div class="inner-container">
          <div class="login-logo mb-4">
            <a href="#"><b><?= SYSTEM_MODULE ?></b></a>
          </div>
          <p class="login-box-msg">Sign in to manage your inventory</p>
          <form action="../../index3.html" method="post">
            <div class="input-group mb-3">
              <input type="text" class="form-control" id="username" placeholder="Username" required autofocus>
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-3">
              <input type="password" class="form-control" id="password" placeholder="Password" required>
              <div class="input-group-append">
                <div class="input-group-text" id="togglePassword">
                  <span class="fas fa-eye"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <button type="button" id="Login" class="btn btn-primary btn-block">Sign In</button>
              </div>
            </div>
          </form>
        </div>
      </div>

      <!-- Right Side - Image -->
      <div class="col-md-6 login-right">
        <img src="<?= base_url()?>/assets/images/logo/zana-logo-green-bg.png" alt="Pharmacy">
      </div>
    </div>
  </div>
</div>



<?php
login_footer();
?>
<script>
  // Toggle Password Visibility
  document.getElementById("togglePassword").addEventListener("click", function() {
    const passwordInput = document.getElementById("password");
    const icon = this.querySelector("span");

    if (passwordInput.type === "password") {
      passwordInput.type = "text";
      icon.classList.remove("fa-eye");
      icon.classList.add("fa-eye-slash");
    } else {
      passwordInput.type = "password";
      icon.classList.remove("fa-eye-slash");
      icon.classList.add("fa-eye");
    }
  });
</script>