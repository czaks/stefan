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

    if (!$users)
      $output = render("login", ["flash" => "Taki użytkownik nie istnieje!"]);
    elseif (!$users[0]->check_password($passwd))
      $output = render("login", ["flash" => "Błędne hasło!"]);
    elseif (!$users[0]->confirmed)
      $output = render("login", ["flash" => "Konto nieaktywne, proszę potwierdzić email!"]);
    else {
      $_SESSION['userid'] = $users[0]->id;
      header("Location: /");
    }
    break;
  case 'register-form':
    $output = render("register", []);
    break;
  case 'register':
    $login = $_POST['login'];
    $passwd = $_POST['password'];
    $passwd2 = $_POST['confirm'];
    $email = $_POST['email'];

    $user = new User();

    $user->login = $login;
    $user->set_password($passwd);
    $user->email = $email;

    $user->confirm_hash = md5(rand(1,10000000));

    if (!$passwd)
      $errors = ["Nie podano hasła"];
    elseif ($passwd != $passwd2)
      $errors = ["Hasła do siebie nie pasują"];
    elseif (User::where("login = ?", [$login]))
      $errors = ["Użytkownik o podanym loginie już istnieje!"];
    else
      $errors = $user->save();

    if ($errors) {
      $output = render("register", ["flash" => implode("<br>", $errors),
                                   "login" => $login,
                                   "passwd" => $passwd,
                                   "passwd2" => $passwd2,
                                   "email" => $email]);
    }
    else {
      $flash = "";

      // Zakomentuj odtąd

      @mail($email, "Rejestracja", "Kliknij w ten link aby kontynuować: http://{$_SERVER['HTTP_HOST']}".
                                    "/account.php?action=activate&code=".$user->confirm_hash)

                                  or
      // Dotąd, jeżeli rejestracja wydaje się trwać w nieskończoność

              $flash = ("Niestety, konfiguracja serwera nie pozwoliła nam wysłać maila. Wejdź pod ten adres: ".
                        "http://{$_SERVER['HTTP_HOST']}/account.php?action=activate&code=".$user->confirm_hash.
                      " , aby aktywować konto.");

      $output = render("register-activation", ["flash" => $flash]);
    }
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
    $code = $_GET['code'];
    $users = User::where("confirmed = 0 and confirm_hash = ?", [$code]);

    if (!$users)
      $output = render("register-activation", ["flash" => "Błędny kod potwierdzający, bądź konto już aktywne"]);
    else {
      $output = render("login", ["flash" => "Aktywacja przebiegła pomyślnie! Proszę się zalogować!", "noerror" => true]);
      $users[0]->confirmed = 1;
      $users[0]->save();
    }

    break;
  case 'logout':
    unset($_SESSION['userid']);
    header("Location: /");
    break;
}

if ($output) layout($output);
