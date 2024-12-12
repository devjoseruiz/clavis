<?php

class Flasher
{

  private $valid_types = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark'];
  private $default = 'primary';
  private $type;
  private $msg;

  /**
   * Method to save a flash notification
   *
   * @param string array $msg
   * @param string $type
   * @return void
   */
  public static function new($msg, $type = null)
  {
    $self = new self();

    // Set default notification type
    if ($type === null) {
      $self->type = $self->default;
    }

    $self->type = in_array($type, $self->valid_types) ? $type : $self->default;

    // Save notification in a session array
    if (is_array($msg)) {
      foreach ($msg as $m) {
        $_SESSION[$self->type][] = $m;
      }

      return true;
    }

    //$_SESSION['primary']['notifications'];
    $_SESSION[$self->type][] = $msg;

    return true;
  }

  /**
   * Renders notifications to our user
   *
   * @return void
   */
  public static function flash()
  {
    $self = new self();
    $output = '';

    foreach ($self->valid_types as $type) {
      if (isset($_SESSION[$type]) && !empty($_SESSION[$type])) {
        foreach ($_SESSION[$type] as $m) {
          $output .= '<div class="alert alert-' . $type . ' alert-dismissible show fade" role="alert">';
          $output .= $m;
          $output .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
          $output .= '</div>';
        }

        unset($_SESSION[$type]);
      }
    }

    return $output;
  }

  /**
   * Shows an access denied message
   *
   * @return void
   */
  public static function deny($type = 0)
  {
    $types =
      [
        0 => 'Unauthorized access.',
        1 => 'Unauthorized action.',
        2 => 'Permission denied.',
        3 => 'You cannot perform this action.'
      ];

    self::new($types[$type], 'danger');
    return true;
  }
}