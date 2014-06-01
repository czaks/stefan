<?php
function render($template, $scope) {
  extract($scope);                     // $scope['test'] to teraz $test
  ob_start();                          // rozpoczynamy buforowanie
  include("templates/$template.html"); // odpalamy szablon
  $ret = ob_get_contents();            // łapiemy wyjście z szablonu
  ob_end_clean();                      // czyścimy bufor
  return $ret;                         // zwracamy to co nam szablon oddał
}
