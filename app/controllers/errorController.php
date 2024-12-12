<?php

class errorController extends Controller
{
  function __construct()
  {
  }

  function index()
  {
    $data =
      [
        'title' => 'Page not found',
        'bg' => 'dark'
      ];
    View::render('404', $data);
  }
}