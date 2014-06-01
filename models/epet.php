<?php
class EPet extends Model {
  static $tablename = "epety"; //nazwa tabeli w sql
  static $validators = [];
}

EPet::add_validator("Pole firma nie może być puste", function($epet) {
  return $epet->firma;
});
EPet::add_validator("Pole model nie może być puste", function($epet) {
  return $epet->model;
});
EPet::add_validator("Pole opis musi być dłuższe niż 10 znaków", function($epet) {
  return strlen($epet->opis) > 10;
});
EPet::add_validator("Pole cena nie może być puste", function($epet) {
  return $epet->cena;
});
EPet::add_validator("Pole cena musi być właściwą liczbą", function($epet) {
  return preg_match("/^[0-9]+(\.[0-9]{1,2})?$/", $epet->cena);
});
EPet::add_validator("Cena musi być mniejsza niż milion złotych", function($epet) {
  return ((float)$epet->cena) < 1000000;
});
