<?php
$prt = isset($context->data->req->prt) ? $context->data->req->prt : null;
$email = isset($context->data->email) ? $context->data->email : null;
?>
<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:150px;">
      <div class="col-md-6 col-lg-4">
        <div class="card">

          <div class="card-header">
            Password reset
            <div id="res"></div>
          </div>
          <div class="card-body">
            <form id="my-form" action="/<?php echo home . route('sendMeTempPassAjax'); ?>" method="post">
              <h3 class="text-center"><?php echo $email; ?></h3>
              <input type="hidden" name="prt" value="<?php echo $prt; ?>">
              <div class="d-grid gap-2">
                <button id="reset-btn" type="button" class="btn btn-primary">Send me temporary password</button>
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
  function handlePassReset(res) {
    if (res.success === true) {
      swalert({
        title: 'Success',
        msg: res.msg,
        icon: 'success',
        gotoLink: `/<?php echo home.route('userLogin'); ?>`
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

  // function swalert(obj) {
  //   Swal.fire(
  //     obj.title,
  //     obj.msg,
  //     obj.icon
  //   ).then(()=>{
  //     if (obj.gotoLink) {
  //       window.location.href = obj.gotoLink;
  //     }
  //   })
  // }
</script>
<?php send_to_server("#reset-btn", "#my-form", "handlePassReset"); ?>