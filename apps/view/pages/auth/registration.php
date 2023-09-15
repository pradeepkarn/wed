<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:100px;">
      <div class="col-md-6 col-lg-4">
        <div class="card">

          <div class="card-header">
          <?php echo lang('global')->registration??'Registration'; ?> <div id="res"></div>
          </div>
          <div class="card-body">
            <form id="my-form" action="/<?php echo home . route('registerAjax'); ?>" method="post">
              <div class="mb-3">
                <label for="email" class="form-label"><?php echo lang('global')->email??'Email'; ?></label>
                <input type="email" class="form-control email" id="email" name="email" required>
                <div class="d-grid">
                  <button type="button" id="send-otp-btn" class="btn btn-sm btn-primary my-2">Send OTP</button>
                </div>
              </div>
              <div class="mb-3">
                <label for="email" class="form-label"><?php echo lang('global')->otp??'OTP'; ?></label>
                <input type="email" class="form-control" id="email" name="otp" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label"><?php echo lang('global')->password??'Password'; ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label"><?php echo lang('global')->confirm_password??'Confirm Password'; ?></label>
                <input type="password" class="form-control" id="password" name="confirm_password" required>
              </div>

              <div class="my-4">
                <input type="checkbox" name="terms_and_conditions_and_privacy_policy" id="tnc">
                <a target="_blank" href="/<?php echo home . route('pageBySlug', ['slug' => 'privacy-policy']); ?>"><?php echo lang('global')->privacy_policy??'Privacy policy'; ?></a> <?php echo lang('global')->and??'and'; ?> 
                <a target="_blank" href="/<?php echo home . route('pageBySlug', ['slug' => 'terms-of-use']); ?>"><?php echo lang('global')->terms_of_use??'Termas of user'; ?>.</a>
                <i class="fas fa-arrow-left"></i>
                <?php echo lang('global')->i_agree??'I agree'; ?>
              </div>
              <div class="d-grid gap-2">
                <button disabled id="login-btn" type="button" class="btn btn-primary"><?php echo lang('nav')->register??'Register'; ?></button>
                <a class="my-3" href="/<?php echo home . route('userLogin'); ?>"><?php echo lang('nav')->login??'Login'; ?></a>
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
<script>
  function handleOtpSend(res) {
    if (res.success === true) {
      swalert({
        title: 'Success',
        msg: res.msg,
        icon: 'success'
      });
    } else if (res.success === false) {
      swalert({
        title: 'Failed',
        msg: res.msg,
        icon: 'error'
      });
    } else {
      swalert({
        title: 'Failed',
        msg: 'Something went wrong',
        icon: 'error'
      });
    }
  }
</script>
<?php 

send_to_server_wotf("#send-otp-btn",".email","handleOtpSend",route('sendOtpAjax'));

pkAjax_form("#login-btn", "#my-form", "#res"); 
?>
<script>
  document.getElementById('popup').style.display = 'none';
</script>