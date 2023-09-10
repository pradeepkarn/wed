<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:150px;">
      <div class="col-md-6 col-lg-4">
        <div class="card">

          <div class="card-header">
            Registration <div id="res"></div>
          </div>
          <div class="card-body">
            <form id="my-form" action="/<?php echo home . route('registerAjax'); ?>" method="post">
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="password" name="confirm_password" required>
              </div>
              <div class="d-grid gap-2">
                <button id="login-btn" type="button" class="btn btn-primary">Register</button>

                <!-- <button class="btn btn-primary" onclick="openFacebookLoginPopup()">
                  <i class="bi bi-facebook"></i>
                </button> -->
                <a class="my-3" href="/<?php echo home.route('userLogin'); ?>">Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php pkAjax_form("#login-btn", "#my-form", "#res"); ?>
<script>
  document.getElementById('popup').style.display = 'none';
</script>