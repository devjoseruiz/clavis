<?php

class View
{

  public static function render($view, $data = [])
  {
    // Convert the associative array to object
    $d = to_object($data); // $data in assoc array or $d in objects

    if (!is_file(VIEWS . CONTROLLER . DS . $view . 'View.php')) {
      die(sprintf('The view "%sView" does not exist in the "%s" folder.', $view, CONTROLLER));
    }

    require_once VIEWS . CONTROLLER . DS . $view . 'View.php';
    exit();
  }
}