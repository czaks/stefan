<?php
class Model {
  static $tablename;
  static $validators = [];
  var $values = [];
  var $index;

  // Konstruktor:
  // - jeżeli index nie został podany, albo jest podany jako 0, to
  //   stwórz nowy rekord
  // - jeżeli został jakiś indeks podany, to zaczytaj wartości
  function __construct($index = 0) {
    global $pdo;

    if ($index) {
      $q = $pdo->prepare("SELECT * FROM ".static::$tablename." WHERE id=:id");
      $q->execute([":id" => $index]);
      $this->values = $q->fetch(PDO::FETCH_ASSOC);
    }
    $this->index = $index;
  }

  // Dodaj walidator. Jeżeli funkcja określona w $validator zwróci fałsz,
  // to dodanie rekordu się nie uda.
  static function add_validator($message, $validator) {
    static::$validators[$message] = $validator;
  }

  // Dla nowych rekordów: stwórz, dla istniejących: zaktualizuj
  // Funkcja zwraca fałsz, jeżeli dodanie się udało
  // W przeciwnym razie zwraca tablice błędów.
  function save() {
    global $pdo;

    $errors = [];
    foreach (static::$validators as $message => $func) {
      $func($this) or $errors[] = $message;
    }
    if ($errors) return $errors; // Jeżeli są błędy, zwróć je.

    $fields = [];
    if ($this->index) {
      $q = "UPDATE ".static::$tablename." SET ";
      foreach ($this->values as $id => $value) {
        $fields[":".$id] = $value;

        $q .= "$id = :$id, ";
      }
      $q = preg_replace("/, $/", "", $q); // Usuwamy ", " z końca zapytania
      $q .= " WHERE id=:id";

      $fields[":id"] = $this->index;
    }
    else {
      $q = "INSERT INTO ".static::$tablename." ";
      $q1 = "id, ";
      $q2 = "NULL, ";

      foreach ($this->values as $id => $value) {
        $fields[":".$id] = $value;

        $q1 .= "$id, ";
        $q2 .= ":$id, ";
      }
      $q1 = preg_replace("/, $/", "", $q1); // Usuwamy ", " z końca fragmentu zapytania
      $q2 = preg_replace("/, $/", "", $q2); // Usuwamy ", " z końca fragmentu zapytania

      $q .= "($q1) VALUES ($q2)";
    }

    $q = $pdo->prepare($q);
    $q->execute($fields);

    return false; // Zwróć fałsz — zapis wykonany pomyślnie.
  }

  function __get($property) { // $obiekt->wiek; — wyświetla wiek danego obiektu
    return $this->values[$property];
  }
  function __set($property, $value) { // $obiekt->wiek = 10; — ustawia wiek obiektu na 10
    return $this->values[$property] = $value;
  }

  static function all($limit = 0, $offset = 0) { // Zwróć wszystkie elementy danego modelu (z ew. limitem)
    global $pdo;

    if ($limit) {
      $q = "SELECT id FROM ".static::$tablename." LIMIT :limit OFFSET :offset";
      $q = $pdo->prepare($q);
      $q->execute([":limit" => $limit, ":offset" => $offset]);
    }
    else {
      $q = "SELECT id FROM ".static::$tablename;
      $q = $pdo->prepare($q);
      $q->execute();
    }

    $values = $q->fetchAll(PDO::FETCH_ASSOC);

    $ret = [];
    foreach ($values as $v) {
      $ret[] = new static((int)$v["id"]);
    }
    return $ret;
  }

  static function where($where, $params = []) { // zapytanie typu where
    global $pdo;

    $q = "SELECT id FROM ".static::$tablename." WHERE $where";
    $q = $pdo->prepare($q);
    $q->execute($params);

    $values = $q->fetchAll(PDO::FETCH_ASSOC);

    $ret = [];
    foreach ($values as $v) {
      $ret[] = new static((int)$v["id"]);
    }
    return $ret;
  }

  // Usuń dany rekord
  function delete() {
    global $pdo;

    $q = "DELETE FROM ".static::$tablename." WHERE id=:id";
    $q = $pdo->prepare($q);
    $q->execute([":id" => $this->index]);
  }

  // Policz rekordy w danej tabeli
  static function count() {
    global $pdo;

    $q = "SELECT COUNT(*) AS cnt FROM ".static::$tablename;
    $q = $pdo->prepare($q);
    $q->execute();
    $q = $q->fetch(PDO::FETCH_ASSOC);
    return $q['cnt'];
  }
}
