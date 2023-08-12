<section style="min-height:100vh;">
<div class="container mt-5">
  <div class="row justify-content-center" style="margin-top:150px;">
    <div class="col-md-6 col-lg-4">
      <div class="card">
        
        <div class="card-header">
          Login <div id="res"></div>
        </div>
        <div class="card-body">
          <form id="my-form" action="/<?php echo home.route('adminLoginAjax'); ?>" method="post">
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="d-grid gap-2">
              <button id="login-btn" type="button" class="btn btn-primary">Login</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section>
<?php pkAjax_form("#login-btn","#my-form","#res"); ?>
