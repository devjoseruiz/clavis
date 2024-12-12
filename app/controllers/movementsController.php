<?php

class movementsController extends Controller
{
  function __construct()
  {
  }

  function index()
  {
    $data =
      [
        'title' => 'My movements',
        'padding' => '0px'
      ];

    View::render('index', $data);
  }
}