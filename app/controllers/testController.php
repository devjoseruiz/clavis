<?php

/**
 * General controller template
 * Version 1.0.2
 *
 * Test controller
 */
class testController extends Controller
{
  function __construct()
  {
    // User session validation, uncomment if required
    /**
    if (!Auth::validate()) {
      Flasher::new('You must login first.', 'danger');
      Redirect::to('login');
    }
    */
  }

  function index()
  {
    register_scripts(['unscript.css'], 'Cool comment for new styles');

    $data =
      [
        'title' => 'Replace title',
        'msg' => 'Welcome to the "test" controller, if you see this message it has been created successfully.'
      ];

    // Uncomment view if required
    View::render('index', $data);
  }

  function view($id)
  {
    View::render('view');
  }

  function add()
  {
    View::render('add');
  }

  function post_add()
  {

  }

  function edit($id)
  {
    View::render('edit');
  }

  function post_edit()
  {

  }

  function delete($id)
  {
    // Delete process
  }
}