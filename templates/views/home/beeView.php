<?php require_once INCLUDES . 'inc_header.php'; ?>

<div id="test_ajax"></div>

<div class="container">
  <div class="row">
    <div class="col-12">
      <?php echo Flasher::flash(); ?>
    </div>
  </div>
  <div class="row">
    <div class="col-8 text-center offset-md-2">
      <a href="<?php echo URL; ?>"><img src="<?php echo get_image('bee_logo_white.png') ?>" alt="Bee framework"
          class="img-fluid" style="width: 200px;"></a>
      <h2 class="text-white mt-5"><span class="text-warning">Bee</span> framework</h2>
      <span class="d-block text-white mb-3"><?php echo sprintf('Version %s', get_bee_version()); ?></span>
      <p class="text-center text-white">A homemade framework, built with passion and lots of care. Light, fast and
        customizable. Use it as you like, in your personal or professional projects.</p>

      <ul class="text-white">
        <li>Developed with PHP, Javascript and HTML5</li>
        <li>Bootstrap 5 Beta</li>
        <li>Works using the <b>MVC</b> pattern</li>
        <li>Session system ready to use</li>
        <li>Simple ORM included for database manipulation</li>
        <li><b>100%</b> customizable and scalable <?php echo more_info('Hello world!'); ?></li>
      </ul>

      <div class="mt-5">
        <a class="btn btn-light btn-lg" href="creator"><i class="fas fa-plus"></i> Creator</a>
        <a class="btn btn-warning btn-lg" href="login">Login</a>
        <a class="btn btn-info btn-lg" href="home/flash">My Account</a>
        <a class="btn btn-success btn-lg" href="https://github.com/Moxtrip69/Bee-Framework"><i
            class="fab fa-github"></i> Github</a>
      </div>

      <div class="mt-5">
        <p class="text-muted">Developed with <i class="fas fa-heart text-danger"></i> by <a
            href="https://www.joystick.com.mx" class="text-white">Joystick</a>.</p>
      </div>
    </div>
  </div>
</div>

<?php require_once INCLUDES . 'inc_footer.php'; ?>