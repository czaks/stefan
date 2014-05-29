<?php
require_once "lib/core.php";

db_init();					// Łączymy się z bazą danych

$initdb = file_get_contents("db/install.sql");	// Ładujemy inicjalną bazę danych do pamięci

$s = explode(";", $initdb);			// Dzielimy po średniku, żeby wykonać kilka
						// zapytań

foreach ($s as $query) {			// Dla każdego zapytania...
  $pdo->query($query);           		// Załaduj je...
  if ((int)$pdo->errorCode()) {
    var_dump($pdo->errorInfo());		// Albo wyświetl błąd
    die();
  }
}

echo "Baza danych załadowana pomyślnie!";
