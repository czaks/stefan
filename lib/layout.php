<?php
function layout($content) {
  global $user, $logged_in;

  echo render("layout",
    ["user" => $user,
     "logged_in" => $logged_in,
     "content" => $content]);
}
