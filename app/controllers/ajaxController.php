<?php

class ajaxController extends Controller
{
  /**
   * The server request
   *
   * @var string
   */
  private $r_type = null;

  /**
   * Requested hook for the request
   *
   * @var string
   */
  private $hook = null;

  /**
   * Type of action to perform in ajax
   *
   * @var string
   */
  private $action = null;

  /**
   * CSRF token from the user session making the request
   *
   * @var string
   */
  private $csrf = null;

  /**
   * All parameters received from the request
   *
   * @var array
   */
  private $data = null;

  /**
   * Parsed parameters in case of put | delete | headers | options request
   *
   * @var mixed
   */
  private $parsed = null;

  /**
   * Value that must be provided as hook to
   * accept an incoming request
   *
   * @var string
   */
  private $hook_name = 'bee_hook'; // If modified, update the value in the core function insert_inputs()

  /**
   * Parameters that will be required in ALL requests passed to ajaxController
   * if one of these is not provided the request will fail
   *
   * @var array
   */
  private $required_params = ['hook', 'action'];

  /**
   * Possible verbs or actions to pass for our request
   *
   * @var array
   */
  private $accepted_actions = ['get', 'post', 'put', 'delete', 'options', 'headers', 'add', 'load'];

  function __construct()
  {
    // Parsing the request body
    $this->r_type = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : null;
    $this->data = in_array($this->r_type, ['PUT', 'DELETE', 'HEADERS', 'OPTIONS']) ? parse_str(file_get_contents("php://input"), $this->parsed) : ($this->r_type === 'GET' ? $_GET : $_POST);
    $this->data = $this->parsed !== null ? $this->parsed : $this->data;
    $this->hook = isset($this->data['hook']) ? $this->data['hook'] : null;
    $this->action = isset($this->data['action']) ? $this->data['action'] : null;
    $this->csrf = isset($this->data['csrf']) ? $this->data['csrf'] : null;

    // Validate that hook exists and is valid
    if ($this->hook !== $this->hook_name) {
      http_response_code(403);
      json_output(json_build(403));
    }

    // Validate that a valid and accepted verb is passed
    if (!in_array($this->action, $this->accepted_actions)) {
      http_response_code(403);
      json_output(json_build(403));
    }

    // Validation that all required parameters are provided
    foreach ($this->required_params as $param) {
      if (!isset($this->data[$param])) {
        http_response_code(403);
        json_output(json_build(403));
      }
    }

    // Validate CSRF token for post / put / delete requests
    if (in_array($this->action, ['post', 'put', 'delete', 'add', 'headers']) && !Csrf::validate($this->csrf)) {
      http_response_code(403);
      json_output(json_build(403));
    }
  }

  function index()
  {
    /**
    200 OK
    201 Created
    300 Multiple Choices
    301 Moved Permanently
    302 Found
    304 Not Modified
    307 Temporary Redirect
    400 Bad Request
    401 Unauthorized
    403 Forbidden
    404 Not Found
    410 Gone
    500 Internal Server Error
    501 Not Implemented
    503 Service Unavailable
    550 Permission denied
    */
    json_output(json_build(403));
  }

  function test()
  {
    try {
      json_output(json_build(200, null, 'AJAX test completed successfully.'));
    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  ///////////////////////////////////////////////////////
  ///////////////////// DEMO PROJECT ////////////////////
  ///////////////////////////////////////////////////////
  function bee_add_movement()
  {
    try {
      $mov = new movementModel();
      $mov->type = $_POST['type'];
      $mov->description = $_POST['description'];
      $mov->amount = (float) $_POST['amount'];
      if (!$id = $mov->add()) {
        json_output(json_build(400, null, 'There was an error saving the record'));
      }

      // Saved successfully
      $mov->id = $id;
      json_output(json_build(201, $mov->one(), 'Movement added successfully'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function bee_get_movements()
  {
    try {
      $movements = new movementModel;
      $movs = $movements->all_by_date();

      $taxes = (float) get_option('taxes') < 0 ? 16 : get_option('taxes');
      $use_taxes = get_option('use_taxes') === 'Yes' ? true : false;

      $total_movements = $movs[0]['total'];
      $total = $movs[0]['total_incomes'] - $movs[0]['total_expenses'];
      $subtotal = $use_taxes ? $total / (1.0 + ($taxes / 100)) : $total;
      $taxes = $subtotal * ($taxes / 100);

      $calculations = [
        'total_movements' => $total_movements,
        'subtotal' => $subtotal,
        'taxes' => $taxes,
        'total' => $total
      ];

      $data = get_module('movements', ['movements' => $movs, 'cal' => $calculations]);
      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, $e->getMessage()));
    }
  }

  function bee_delete_movement()
  {
    try {
      $mov = new movementModel();
      $mov->id = $_POST['id'];

      if (!$mov->delete()) {
        json_output(json_build(400, null, 'There was an error deleting the record'));
      }

      json_output(json_build(200, null, 'Movement deleted successfully'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function bee_update_movement()
  {
    try {
      $movement = new movementModel;
      $movement->id = $_POST['id'];
      $mov = $movement->one();

      if (!$mov) {
        json_output(json_build(400, null, 'The movement does not exist'));
      }

      $data = get_module('updateForm', $mov);
      json_output(json_build(200, $data));
    } catch (Exception $e) {
      json_output(json_build(400, $e->getMessage()));
    }
  }

  function bee_save_movement()
  {
    try {
      $mov = new movementModel();
      $mov->id = $_POST['id'];
      $mov->type = $_POST['type'];
      $mov->description = $_POST['description'];
      $mov->amount = (float) $_POST['amount'];
      if (!$mov->update()) {
        json_output(json_build(400, null, 'There was an error saving the changes'));
      }

      // Saved successfully
      json_output(json_build(200, $mov->one(), 'Movement updated successfully'));

    } catch (Exception $e) {
      json_output(json_build(400, null, $e->getMessage()));
    }
  }

  function bee_save_options()
  {
    $options =
      [
        'use_taxes' => $_POST['use_taxes'],
        'taxes' => (float) $_POST['taxes'],
        'coin' => $_POST['coin']
      ];

    foreach ($options as $k => $option) {
      try {
        if (!$id = optionModel::save($k, $option)) {
          json_output(json_build(400, null, sprintf('There was an error saving the option %s', $k)));
        }

      } catch (Exception $e) {
        json_output(json_build(400, null, $e->getMessage()));
      }
    }

    // Saved successfully
    json_output(json_build(200, null, 'Options updated successfully'));
  }
  ///////////////////////////////////////////////////////
  ///////////////// END OF DEMO PROJECT /////////////////
  ///////////////////////////////////////////////////////
}