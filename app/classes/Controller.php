<?php

class Controller
{

  function __construct()
  {

  }

  function test()
  {
    echo 'Testing Controller...';
  }

  /**
   * Function to validate a user's session, can be used
   * in any child controller or that extends the Controller
   *
   * @return void
   */
  function auth()
  {
    if (!Auth::validate()) {
      Flasher::new('Protected area, you must log in to view the content.', 'danger');
      Redirect::back('login');
    }
  }
}