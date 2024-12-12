<?php

/**
 * Controller for dynamically generating models and controllers
 */
class creatorController extends Controller
{
  function __construct()
  {
  }

  function index()
  {
    View::render('index', ['title' => 'Create a new file']);
  }

  function controller()
  {
    View::render('controller', ['title' => 'New controller']);
  }

  function model()
  {
    View::render('model', ['title' => 'New model']);
  }

  function post_controller()
  {
    if (!Csrf::validate($_POST['csrf'])) {
      Flasher::deny();
      Redirect::back();
    }

    // Validate file name
    $filename = clean($_POST['filename']);
    $filename = strtolower($filename);
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('.php', '', $filename);
    $keyword = 'Controller';
    $template = MODULES . 'controllerTemplate.txt';

    // Validate the existence of the controller to prevent removing an existing file
    if (is_file(CONTROLLERS . $filename . $keyword . '.php')) {
      Flasher::new(sprintf('The controller %s already exists.', $filename . $keyword), 'danger');
      Redirect::back();
    }

    // Validate the existence of the .txt template to create the controller
    if (!is_file($template)) {
      Flasher::new(sprintf('The template %s does not exist.', $template), 'danger');
      Redirect::back();
    }

    // Load file content
    $php = @file_get_contents($template);
    $php = str_replace('[[REPLACE]]', $filename, $php);
    if (file_put_contents(CONTROLLERS . $filename . $keyword . '.php', $php) === false) {
      Flasher::new(sprintf('There was a problem creating the controller %s.', $template), 'danger');
      Redirect::back();
    }

    // Create the folder in the views directory
    if (!is_dir(VIEWS . $filename)) {
      mkdir(VIEWS . $filename);

      $body =
        '<?php require_once INCLUDES.\'inc_header.php\'; ?>
      <div class="container">
        <div class="row">
          <div class="col-6 text-center offset-xl-3">
            <a href="<?php echo URL; ?>"><img src="<?php echo IMAGES.\'bee_logo.png\' ?>" alt="Bee framework" class="img-fluid" style="width: 200px;"></a>
            <h2 class="mt-5 mb-3"><span class="text-warning">Bee</span> framework</h2>
            <!-- content -->
            <h1><?php echo $d->msg; ?></h1>
            <!-- ends -->
          </div>
        </div>
      </div>
      
      <?php require_once INCLUDES.\'inc_footer.php\'; ?>';

      @file_put_contents(VIEWS . $filename . DS . 'indexView.php', $body);
    }

    // Create a default view
    Redirect::to($filename);
  }

  function post_model()
  {
    if (!Csrf::validate($_POST['csrf'])) {
      Flasher::deny();
      Redirect::back();
    }

    // Validate file name
    $filename = clean($_POST['filename']);
    $filename = strtolower($filename);
    $filename = str_replace(' ', '_', $filename);
    $filename = str_replace('.php', '', $filename);
    $keyword = 'Model';
    $template = MODULES . 'modelTemplate.txt';

    if (is_file(CONTROLLERS . $filename . $keyword . '.php')) {
      Flasher::new(sprintf('The model %s already exists.', $filename . $keyword), 'danger');
      Redirect::back();
    }

    if (!is_file($template)) {
      Flasher::new(sprintf('The template %s does not exist.', $template), 'danger');
      Redirect::back();
    }

    // Load file content
    $php = @file_get_contents($template);
    $php = str_replace('[[REPLACE]]', $filename, $php);
    if (file_put_contents(MODELS . $filename . $keyword . '.php', $php) === false) {
      Flasher::new(sprintf('There was a problem creating the model %s.', $template), 'danger');
      Redirect::back();
    }

    Flasher::new(sprintf('Model %s created successfully.', $filename . $keyword));
    Redirect::back();
  }
}