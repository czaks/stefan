<?php
require_once "lib/core.php";

$action = isset($_GET['action']) ? 'login-form' : $_GET['action'];

$output = "";

switch ($action) {
  case 'login-form':

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
