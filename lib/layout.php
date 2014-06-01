<?php
function layout($content) { // Skrótowiec, ma nam ułatwić pracę
  global $user, $logged_in;

  echo render("layout",
    ["user" => $user,
     "logged_in" => $logged_in,
     "content" => $content]);
}
