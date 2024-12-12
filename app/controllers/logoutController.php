<?php

class logoutController extends Controller
{
  function __construct()
  {
  }

  function index()
  {
    if (!Auth::validate()) {
      Flasher::new('There is no active session. We cannot log you out.', 'danger');
      Redirect::to('login');
    }

    Auth::logout();
    Redirect::to('login');
  }
}