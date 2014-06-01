<?php
require_once "lib/core.php";
$action = isset ($_GET['action']) ? $_GET['action'] : "read";
$id = isset ($_GET['id']) ? $_GET['id'] : 0;
$page = isset ($_GET['page']) ? $_GET['page'] : 0;

$output = "";

switch ($action) {
  // create i update są bardzo podobne, więc traktujemy je razem
  case "create-form":
  case "update-form":
    $epet = new EPet($id);
    $output = render("epet-form", ["id" => $id, "firma" => $epet->firma, "opis" => $epet->opis,
                                   "model" => $epet->model, "opinia" => $epet->opinia,
                                   "cena" => $epet->cena]);

    break;
  case "read":
    // Wyświetl listę, 4 elementy, poczynając od $strona*4 elementu.
    $output = render("epet-list", ["page" => $page, "epety" => EPet::all(4, $page*4), "count" => EPet::count()]);
    break;
  // create i update są bardzo podobne, więc traktujemy je razem
  case "create":
  case "update":
    $epet = new EPet($id);

    $epet->firma  = $_POST['firma'];
    $epet->opis   = $_POST['opis'];
    $epet->model  = $_POST['model'];
    $epet->opinia = $_POST['opinia'];
    $epet->cena   = $_POST['cena'];

    $errors = $epet->save();

    if ($errors) {
      $output = render("epet-form", ["id" => $id, "firma" => $epet->firma, "opis" => $epet->opis,
                                     "model" => $epet->model, "opinia" => $epet->opinia,
                                     "cena" => $epet->cena, "flash" => implode("<br>", $errors)]);
    }
    else {
      // Wyświetl listę, 4 elementy, poczynając od $strona*4 elementu.
      $output = render("epet-list", ["page" => $page, "epety" => EPet::all(4, $page*4), "count" => EPet::count(),
                                     "flash" => "E-Papieros został pomyślnie ".($id?"zaktualizowany":"dodany"), "noerror" => true]);
    }

    break;
  case "delete":
    $epet = new EPet($id);
    $epet->delete();

    // Wyświetl listę, 4 elementy, poczynając od $strona*4 elementu.
    $output = render("epet-list", ["page" => $page, "epety" => EPet::all(4, $page*4), "count" => EPet::count(),
                                   "flash" => "E-Papieros został pomyślnie usunięty", "noerror" => true]);
    break;
}


if ($output) layout($output);
