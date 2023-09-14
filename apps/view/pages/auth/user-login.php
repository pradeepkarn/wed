<section style="min-height:100vh;">
  <div class="container mt-5">
    <div class="row justify-content-center" style="margin-top:100px;">
      <div class="col-md-6 col-lg-4">
        <div class="card">

          <div class="card-header">
            <?php echo lang('nav')->login??'Login'; ?> <div id="res"></div>
          </div>
          <div class="card-body">
            <form id="my-form" action="/<?php echo home . route('userLoginAjax'); ?>" method="post">
              <div class="mb-3">
                <label for="username" class="form-label"><?php echo lang('global')->email??'Email'; ?>/<?php echo lang('global')->username??'Username'; ?></label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label"><?php echo lang('global')->password??'Password'; ?></label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="d-grid gap-2">
                <button id="login-btn" type="button" class="btn btn-primary"> <?php echo lang('nav')->login??'Login'; ?></button>
                <!-- <button type="button" class="btn btn-primary" onclick="openFacebookLoginPopup()">
                  <i class="bi bi-facebook"></i>
                </button> -->

                <script>
                  document.getElementById('popup').style.display = 'none';
                </script>
                <a class="my-3" href="/<?php echo home.route('register'); ?>"><?php echo lang('nav')->register??'Register'; ?></a>
                <a class="my-3" href="/<?php echo home.route('resetPassword'); ?>"><?php echo lang('global')->reset_password??'Reset password'; ?></a>
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
  //   const form = document.querySelector('#my-form');
  //   form.addEventListener('submit', handleSubmit);

  //   function handleSubmit(event) {
  //     event.preventDefault();
  //     const formData = new FormData(form);
  //     fetch('/<?php echo home; ?>/user-login-ajax', {
  //       method: 'POST',
  //       body: formData
  //     })
  //     .then(response => response.json())
  //     .then(data => {
  //       // handle response from server
  //       document.getElementById('res').innerText = data;
  //       alert(data);
  //     })
  //     .catch(error => {
  //       // handle error
  //       document.getElementById('res').innerText = error;
  //     });
  //   }
</script>