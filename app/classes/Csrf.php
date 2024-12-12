<?php

class Csrf
{

  private $length = 32; // length of our token
  private $token; // token
  private $token_expiration; // expiration time
  private $expiration_time = 60 * 5; // 5 minutes expiration

  // Create our token if it doesn't exist and it's the first site access
  public function __construct()
  {
    if (!isset($_SESSION['csrf_token'])) {
      $this->generate();
      $_SESSION['csrf_token'] =
        [
          'token' => $this->token,
          'expiration' => $this->token_expiration
        ];
      return $this;
    }

    $this->token = $_SESSION['csrf_token']['token'];
    $this->token_expiration = $_SESSION['csrf_token']['expiration'];

    return $this;
  }

  /**
   * Method to generate a new token
   *
   * @return void
   */
  private function generate()
  {
    if (function_exists('bin2hex')) {
      $this->token = bin2hex(random_bytes($this->length)); // ASDFUHASIO32Jasdasdjf349mfjads9mfas4asdf
    } else {
      $this->token = bin2hex(openssl_random_pseudo_bytes($this->length)); // asdfuhasi487a9s49mafmsau84
    }

    $this->token_expiration = time() + $this->expiration_time;
    return $this;
  }

  /**
   * Validate the request token with the system token
   *
   * @param string $csrf_token
   * @param boolean $validate_expiration
   * @return void
   */
  public static function validate($csrf_token, $validate_expiration = false)
  {
    $self = new self();

    // Validating token expiration time
    if ($validate_expiration && $self->get_expiration() < time()) {
      return false;
    }

    if ($csrf_token !== $self->get_token()) {
      return false;
    }

    return true;
  }

  /**
   * Method to get the token
   *
   * @return void
   */
  public function get_token()
  {
    return $this->token;
  }

  /**
   * Method to get token expiration
   *
   * @return void
   */
  public function get_expiration()
  {
    return $this->token_expiration;
  }
}