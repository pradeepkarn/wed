<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:100px;">
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

              <div class="my-4">
                <input type="checkbox" name="terms_and_conditions_and_privacy_policy" id="tnc"> I have read 
                <a target="_blank" href="/<?php echo home . route('pageBySlug', ['slug' => 'privacy-policy']); ?>">Privacy policy</a> and accepted
                <a target="_blank" href="/<?php echo home . route('pageBySlug', ['slug' => 'terms-and-conditions']); ?>">Terms and conditions.</a>
              </div>
              <div class="d-grid gap-2">
                <button disabled id="login-btn" type="button" class="btn btn-primary">Register</button>
                <a class="my-3" href="/<?php echo home . route('userLogin'); ?>">Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('tnc');
    const registerBtn = document.getElementById('login-btn');

    checkbox.addEventListener('change', function () {
      if (checkbox.checked) {
        registerBtn.disabled = false;
      } else {
        registerBtn.disabled = true;
      }
    });
  });
</script>

<?php pkAjax_form("#login-btn", "#my-form", "#res"); ?>
<script>
  document.getElementById('popup').style.display = 'none';
</script>