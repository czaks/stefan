<?php
function render($template, $scope) {
  extract($scope);                     // $scope['test'] to teraz $test
  ob_start();                          // rozpoczynamy buforowanie
  error_reporting(E_ALL ^ E_NOTICE);   // nie pokazuj noticów
  include("templates/$template.html"); // odpalamy szablon
  error_reporting(E_ALL);              // włącz je spowrotem
  $ret = ob_get_contents();            // łapiemy wyjście z szablonu
  ob_end_clean();                      // czyścimy bufor
  return $ret;                         // zwracamy to co nam szablon oddał
}
