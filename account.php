<?php
require_once "lib/core.php";

$action = isset($_GET['action']) ? $_GET['action'] : 'login-form';

$output = "";

switch ($action) {
  case 'login-form': // formularz logowania
    $output = render("login", []);
    break;
  case 'login': // logowanie wlasciwe
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
      header("Location: .");
    }
    break;
  case 'logout': // wylogowanie sie
    unset($_SESSION['userid']);
    header("Location: .");
    break;
  case 'register-form': // formularz rejestracji
    $output = render("register", []);
    break;
  case 'register': // rejestracja wlasciwa
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
      /*
      @mail($email, "Rejestracja", "Kliknij w ten link aby kontynuować: http://{$_SERVER['HTTP_HOST']}".
                                    "{$_SERVER['PHP_SELF']}?action=activate&code=".$user->confirm_hash)

                                  or*/
      // Dotąd, jeżeli rejestracja wydaje się trwać w nieskończoność

              $flash = ("Niestety, konfiguracja serwera nie pozwoliła nam wysłać maila. Wejdź pod ten adres: ".
                        "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?action=activate&code=".$user->confirm_hash.
                      " , aby aktywować konto.");

      $output = render("register-activation", ["flash" => $flash]);
    }
    break;
  case 'activate': // aktywacja konta
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
  case 'remind-form': // formularz przypomienia hasla
    $output = render("remind", []);
    break;
  case 'remind': // wyslanie maila
    $email = $_POST['email'];
    $users = User::where("email = ?", [$email]);
    if (!$users)
      $flash = "Użytkownik nie istnieje!";
    elseif ($users[0]->confirmed == 0)
      $flash = "Użytkownik nie jest potwierdzony";
    else {
      $flash = "Wysłałem maila potwierdzającego!";

      $users[0]->recovery = md5(rand(1,10000000));
      $users[0]->save();
      // Zakomentuj odtąd
      /*
      @mail($email, "Przypomnienie hasła", "Kliknij w ten link aby kontynuować: http://{$_SERVER['HTTP_HOST']}".
                                    "{$_SERVER['PHP_SELF']}?action=remind-restore-form&code=".$users[0]->recovery)

                                  or*/
      // Dotąd, jeżeli przypominanie hasłą wydaje się trwać w nieskończoność (albo nie działa)

              $flash = ("Niestety, konfiguracja serwera nie pozwoliła nam wysłać maila. Wejdź pod ten adres: ".
                        "http://{$_SERVER['HTTP_HOST']}{$_SERVER['PHP_SELF']}?action=remind-restore-form&code=".$users[0]->recovery.
                      " , aby aktywować konto.");
    }

    $output = render("remind", ["flash" => $flash]);

    break;
  case 'remind-restore-form': // przypomnienie hasla - formularz zmiany hasla (link otrzymany mailem)
    $code = $_GET['code'];
    $users = User::where("recovery = ?", [$code]);
    if ($users)
      $output = render("remind-restore", ["code" => $code]);
    else
      $output = render("remind", ["flash" => "Błędny kod!"]);

    break;
  case 'remind-restore': // przypomienie hasla - zmiana hasla
    $code = $_GET['code'];
    $users = User::where("recovery = ?", [$code]);

    $passwd = $_POST['password'];
    $passwd2 = $_POST['confirm'];

    if (!$users)
      $output = render("remind", ["flash" => "Błędny kod!"]);
    elseif (!$passwd)
      $output = render("remind-restore", ["code" => $code, "flash" => "Hasło nie może być puste"]);
    elseif ($passwd != $passwd2)
      $output = render("remind-restore", ["code" => $code, "flash" => "Hasła się nie zgadzają"]);
    else {
      $users[0]->set_password($passwd);
      $users[0]->save();
      $output = render("login", ["flash" => "Zmiana hasła przebiegła pomyślnie! Proszę się zalogować!", "noerror" => true]);
    }
    break;
  default:
    $output = "You have reached the end of the Internet, congratulations!";
}

if ($output) layout($output);
