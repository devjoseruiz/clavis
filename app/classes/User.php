<?php
/**
 * Contains user information
 */
class User extends Auth
{
  private $user = [];
  private $is_logged = false;

  /**
   * Validates the existence of the session and its validity in the system
   */
  public function __construct()
  {
    // Validate the current session state of the user
    // Check the existence of the session variable
    // to prevent errors
    $auth = new parent();
    $this->is_logged = parent::validate();
    if ($this->is_logged === false) {
      return false;
    }

    // Validate the existence of the column in the user information
    if (!isset($_SESSION[$auth->__get('var')]))
      return false;
    if (!isset($_SESSION[$auth->__get('var')]['user']))
      return false;

    $this->user = $_SESSION[$auth->__get('var')]['user'];
    return true;
  }

  /**
   * Loads the value of a column from the information
   * of a logged in user
   *
   * @param string $column
   * @return mixed
   */
  public static function get($column)
  {
    $user = new self();
    $auth = new parent();
    if (!$user)
      return false;

    // Validates the existence of the column
    if (!isset($_SESSION[$auth->__get('var')]['user'][$column]))
      return false;
    return $_SESSION[$auth->__get('var')]['user'][$column];
  }

  /**
   * Method to load the entire profile of a user stored in session
   *
   * @return mixed
   */
  public static function profile()
  {
    $user = new self();
    $auth = new parent();
    if (!$user)
      return false;

    return $user->user;
  }
}
