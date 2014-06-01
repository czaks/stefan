<?php
class User extends Model {
  static $tablename = "users";
  static $validators = [];

  function set_password($password) {
    $this->password = crypt($password, "$1$".rand(1,10000000)."$");
  }

  function check_password($password) {
    return crypt($password, $this->password) == $this->password;
  }
}

User::add_validator("Użytkownik musi mieć podany poprawny adres e-mail", function($user) {
  return preg_match("/^.*@.*\..*$/", $user->email); // Adres e-mail w formie: costam@costam.costam
});
User::add_validator("Użytkownik musi mieć podany login", function($user) {
  return preg_match("/^.+$/", $user->login); // Login przynajmniej jeden znak
});
User::add_validator("Użytkownik musi mieć podane hasło", function($user) {
  return preg_match("/^.+$/", $user->password); // Login przynajmniej jeden znak
});
