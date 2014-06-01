<?php
require_once "lib/core.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'login-form';

$output = "";

switch ($action) {
  case 'login-form':
    $output = render("login", []);
    break;
  case 'login':

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
    $_SESSION['userid'] = false;
    header("Location: /");
    die();
    break;
}

layout($output);
