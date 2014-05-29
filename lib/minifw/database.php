<?php
$pdo = false;

function db_init() {
  global $config, $pdo;

  // Ustawiamy brakujące zmienne.
  if (!isset ($config['db']['user'  ])) $config['db']['user'  ] = null;
  if (!isset ($config['db']['passwd'])) $config['db']['passwd'] = null;

  // Nawiązujemy połączenie z bazą danych
  $pdo = new PDO($config['db']['dsn'],
                 $config['db']['user'],
                 $config['db']['passwd']);
}
