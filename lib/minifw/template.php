<?php
function render($template, $scope) {
  extract($scope);                     // $scope['test'] to teraz $test
  ini_set("short_open_tag", true);     // włączamy krótkie tagi <?, <?=, ? >
  ob_start();                          // rozpoczynamy buforowanie
  include("templates/$template.html"); // odpalamy szablon
  $ret = ob_get_contents();            // łapiemy wyjście z szablonu
  ob_end_clean();                      // czyścimy bufor
  ini_set("short_open_tag", false);    // wyłączamy krótkie tagi <?, <?=, ? >
  return $ret;                         // zwracamy to co nam szablon oddał
}
