<?php
require_once "lib/core.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'login-form';

$output = "";

switch ($action) {
  case 'login-form':
    $output = render("login", []);
    break;
  case 'login':
    $login = $_POST['login'];
    $passwd = $_POST['passwd'];
    $users = User::where("login = ?", [$login]);

    if (!$users) {
      $output = render("login", ["flash" => "Taki użytkownik nie istnieje!"]);
      break;
    }
    if (!$users[0]->check_password($passwd)) {
      $output = render("login", ["flash" => "Błędne hasło!"]);
      break;
    }
    $_SESSION['userid'] = $users[0]->id;
    header("Location: /");
    break;
  case 'register-form':

    break;
  case 'register':

    break;
  case 'remind-form':

    break;
  case 'remind':

    break;
  case 'remind-restore-form':

    break;
  case 'remind-restore':

    break;
  case 'activate':

    break;
  case 'logout':
    unset($_SESSION['userid']);
    header("Location: /");
    break;
}

if ($output) layout($output);
