<?php

class loginController extends Controller
{
  function __construct()
  {
    if (Auth::validate()) {
      Flasher::new('A session is already active.');
      Redirect::to('home/flash');
    }
  }

  function index()
  {
    $data =
      [
        'title' => 'Login to your account',
        'padding' => '0px'
      ];

    View::render('index', $data);
  }

  function post_login()
  {
    if (!Csrf::validate($_POST['csrf']) || !check_posted_data(['usuario', 'csrf', 'password'], $_POST)) {
      Flasher::new('Unauthorized access.', 'danger');
      Redirect::back();
    }

    // Data passed from the form
    $usuario = clean($_POST['usuario']);
    $password = clean($_POST['password']);

    // Logged user information, this can be replaced with a database query
    // to load user information if it exists
    $user =
      [
        'id' => 123,
        'name' => 'Bee Default',
        'email' => 'hellow@joystick.com.mx',
        'avatar' => 'myavatar.jpg',
        'tel' => '11223344',
        'color' => '#112233',
        'user' => 'bee',
        'password' => '$2y$10$R18ASm3k90ln7SkPPa7kLObcRCYl7SvIPCPtnKMawDhOT6wPXVxTS'
      ];


    if ($usuario !== $user['user'] || !password_verify($password . AUTH_SALT, $user['password'])) {
      Flasher::new('Invalid credentials.', 'danger');
      Redirect::back();
    }

    // Log in the user
    Auth::login($user['id'], $user);
    Redirect::to('home/flash');
  }
}