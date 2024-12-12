<?php

class Bee
{

  // Framework properties
  // Developed by the Joystick team
  /**
   * Suggestions or pull requests to:
   * hellow@joystick.com.mx
   * 
   * Roberto Orozco / roborozco@joystick.com.mx
   * Lucerito Ortega / lucortega@joystick.com.mx
   * Yoshio Mrtz / yosmartinez@joystick.com.mx
   * Kevin Sm / kevsamano@joystick.com.mx
   * 
   * Thanks for all your support!
   *
   * @var string
   */
  private $framework = 'Bee Framework'; // This will now only be the framework identifier name and not the system name itself
  private $version = '1.1.3';         // current version of the framework, not the system under development, the system version should be updated directly in bee_config.php
  private $lng = 'en';
  private $uri = [];
  private $use_composer = true;

  // The main function that runs when instantiating our class
  function __construct()
  {
    $this->init();
  }

  /**
   * Method to execute each "method" subsequently
   *
   * @return void
   */
  private function init()
  {
    // All methods we want to execute consecutively
    $this->init_session();
    $this->init_load_config();
    $this->init_load_functions();
    $this->init_load_composer();
    $this->init_autoload();
    $this->init_csrf();
    $this->init_globals();
    $this->init_custom();
    $this->dispatch();
  }

  /**
   * Method to start the system session
   * 
   * @return void
   */
  private function init_session()
  {
    if (session_status() == PHP_SESSION_NONE) {
      session_start();
    }

    return;
  }

  /**
   * Method to load system configuration
   *
   * @return void
   */
  private function init_load_config()
  {
    // Loading the settings file initially to establish custom constants
    // from the beginning of site execution
    $file = 'bee_config.php';
    if (!is_file('app/config/' . $file)) {
      die(sprintf('The file %s was not found, it is required for %s to work.', $file, $this->framework));
    }

    // Loading configuration file
    require_once 'app/config/' . $file;

    $file = 'settings.php';
    if (!is_file('app/core/' . $file)) {
      die(sprintf('The file %s was not found, it is required for %s to work.', $file, $this->framework));
    }

    // Loading configuration file
    require_once 'app/core/' . $file;

    return;
  }

  /**
   * Method to load all system and user functions
   *
   * @return void
   */
  private function init_load_functions()
  {
    $file = 'bee_core_functions.php';
    if (!is_file(FUNCTIONS . $file)) {
      die(sprintf('The file %s was not found, it is required for %s to work.', $file, $this->framework));
    }

    // Loading core functions file
    require_once FUNCTIONS . $file;

    $file = 'bee_custom_functions.php';
    if (!is_file(FUNCTIONS . $file)) {
      die(sprintf('The file %s was not found, it is required for %s to work.', $file, $this->framework));
    }

    // Loading custom functions file
    require_once FUNCTIONS . $file;

    return;
  }

  /**
   * Initialize composer
   */
  private function init_load_composer()
  {
    if (!$this->use_composer) {
      return;
    }

    $file = 'app/vendor/autoload.php';
    if (!is_file($file)) {
      die(sprintf('The file %s was not found, it is required for %s to work.', $file, $this->framework));
    }

    // Loading configuration file
    require_once $file;

    return;
  }

  /**
   * Method to load all files automatically
   *
   * @return void
   */
  private function init_autoload()
  {
    require_once CLASSES . 'Autoloader.php';
    Autoloader::init();
    return;
  }

  /**
   * Method to create a new user session token
   *
   * @return void
   */
  private function init_csrf()
  {
    $csrf = new Csrf();
    define('CSRF_TOKEN', $csrf->get_token()); // Version 1.0.2 for use in applications
  }

  /**
   * Initialize system globals
   *
   * @return void
   */
  private function init_globals()
  {
    // Bee object that will be inserted in the footer as dynamic javascript script for easy access
    bee_obj_default_config();

    //////////////////////////////////////////////
  }

  /**
   * Used for loading custom system processes
   * functions, variables, set up
   *
   * @return void
   */
  private function init_custom()
  {
    // Initialize custom system or application processes
    // ........
  }

  /**
   * Method to filter and break down the elements of our url and uri
   *
   * @return void
   */
  private function filter_url()
  {
    if (isset($_GET['uri'])) {
      $this->uri = $_GET['uri'];
      $this->uri = rtrim($this->uri, '/');
      $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
      $this->uri = explode('/', strtolower($this->uri));
      return $this->uri;
    }
  }

  /**
   * Method to execute and load the controller requested by the user
   * its method and pass parameters to it.
   *
   * @return void
   */
  private function dispatch()
  {

    // Filter the URL and separate the URI
    $this->filter_url();

    /////////////////////////////////////////////////////////////////////////////////
    // We need to know if the name of a controller is being passed in our URI
    // $this->uri[0] is the controller in question
    if (isset($this->uri[0])) {
      $current_controller = $this->uri[0]; // users Controller.php
      unset($this->uri[0]);
    } else {
      $current_controller = DEFAULT_CONTROLLER; // home Controller.php
    }

    // Execute the controller
    // Check if there is a class with the requested controller
    $controller = $current_controller . 'Controller'; // homeController
    if (!class_exists($controller)) {
      $current_controller = DEFAULT_ERROR_CONTROLLER; // To make the CONTROLLER error
      $controller = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
    }

    /////////////////////////////////////////////////////////////////////////////////
    // Execute the requested method
    if (isset($this->uri[1])) {
      $method = str_replace('-', '_', $this->uri[1]);

      // Does the method exist within the class to be executed (controller)
      if (!method_exists($controller, $method)) {
        $controller = DEFAULT_ERROR_CONTROLLER . 'Controller'; // errorController
        $current_method = DEFAULT_METHOD; // index
        $current_controller = DEFAULT_ERROR_CONTROLLER;
      } else {
        $current_method = $method;
      }

      unset($this->uri[1]);
    } else {
      $current_method = DEFAULT_METHOD; // index
    }

    /////////////////////////////////////////////////////////////////////////////////
    // Create constants to use later
    define('CONTROLLER', $current_controller);
    define('METHOD', $current_method);

    /////////////////////////////////////////////////////////////////////////////////
    // Execute the controller and method as requested
    $controller = new $controller;

    // Get the parameters from the URI
    $params = array_values(empty($this->uri) ? [] : $this->uri);

    // Call the method requested by the current user
    if (empty($params)) {
      call_user_func([$controller, $current_method]);
    } else {
      call_user_func_array([$controller, $current_method], $params);
    }

    return; // Final line, everything happens between this line and the beginning
  }

  /**
   * Run our framework
   *
   * @return void
   */
  public static function fly()
  {
    $bee = new self();
    return;
  }
}