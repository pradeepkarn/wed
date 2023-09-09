<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:150px;">
      <div class="col-md-6 col-lg-4">
        <div class="card">

          <div class="card-header">
            Reset password <div id="res"></div>
          </div>
          <div class="card-body">
            <form id="my-form" action="/<?php echo home . route('resetPasswordAjax'); ?>" method="post">
              <div class="mb-3">
                <label for="username" class="form-label">Your registered email</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

              <div class="d-grid gap-2">
                <button id="reset-btn" type="button" class="btn btn-primary">Send</button>
                <p id="please-wait-text" class="text-center">Please wait ...
                  <img src="/<?php echo MEDIA_URL; ?>/site/loading.gif" alt="Loading...">
                </p>
                <a class="my-2" href="/<?php echo home . route('userLogin'); ?>">Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  function handlePassReset(res) {
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
send_to_server("#reset-btn", "#my-form", "handlePassReset");
ajaxActive("#please-wait-text");
?>