<?php
session_start();
db_init();

$logged_in = false;

// Jeżeli istnieje identifikator sesji, to ustaw, że
// użytkownik zalogowany i zaczytaj go do zmiennej $user
if (isset ($_SESSION['userid']) && !$installing) {
  $logged_in = true;
  $user = new User($_SESSION['userid']);
}
