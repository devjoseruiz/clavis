<?php

class Redirect
{
  private $location;

  /**
   * Method to redirect the user to a specific section
   *
   * @param string $location
   * @return void
   */
  public static function to($location)
  {
    $self = new self();
    $self->location = $location;

    // If headers were already sent
    if (headers_sent()) {
      echo '<script type="text/javascript">';
      echo 'window.location.href="' . URL . $self->location . '";';
      echo '</script>';
      echo '<noscript>';
      echo '<meta http-equiv="refresh" content="0;url=' . URL . $self->location . '" />';
      echo '</noscript>';
      die();
    }

    // When passing an external URL to our site
    if (strpos($self->location, 'http') !== false) {
      header('Location: ' . $self->location);
      die();
    }

    // Redirect the user to another section
    header('Location: ' . URL . $self->location);
    die();
  }

  /**
   * Redirects back to the previous URL
   *
   * @param string $location
   * @return void
   */
  public static function back($location = '')
  {
    if (!isset($_POST['redirect_to']) && !isset($_GET['redirect_to']) && $location == '') {
      header('Location: ' . URL . DEFAULT_CONTROLLER);
      die();
    }

    if (isset($_POST['redirect_to'])) {
      header('Location: ' . $_POST['redirect_to']);
      die();
    }

    if (isset($_GET['redirect_to'])) {
      header('Location: ' . $_GET['redirect_to']);
      die();
    }

    if (!empty($location)) {
      self::to($location);
    }
  }
}