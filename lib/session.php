<?php
session_start();
db_init();

$logged_in = false;

if (isset ($_SESSION['userid']) && !$installing) {
  $logged_in = true;
  $user = new User($_SESSION['userid']);
}
