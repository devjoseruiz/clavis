<?php require_once INCLUDES.'inc_header.php'; ?>

<div class="container">
  <div class="py-5 text-center">
    <a href="<?php echo URL; ?>"><img src="<?php echo IMAGES.'bee_logo.png' ?>" alt="Bee framework" class="img-fluid" style="width: 200px;"></a>
    <h2>Login to your account</h2>
    <p class="lead">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam, ullam.</p>
  </div>

  <div class="row">
    <div class="col-12">
      <?php echo Flasher::flash(); ?>
    </div>

    <!-- form -->
    <div class="col-xl-12">
      <div class="card">
        <div class="card-header">
          <h4>Login to your account</h4>
        </div>
        <div class="card-body">
          <form action="login/post_login" method="post" novalidate>
            <?php echo insert_inputs(); ?>
            
            <div class="mb-3 row">
              <div class="col-xl-6">
                <label for="usuario">Username</label>
                <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Walter White" required>
                <small class="text-muted">Enter bee</small>
              </div>
              <div class="col-xl-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <small class="text-muted">Enter 123456</small>
              </div>
            </div>

            <button class="btn btn-primary btn-block" type="submit">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require_once INCLUDES.'inc_footer_v2.php'; ?>
