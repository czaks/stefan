document.addEventListener("DOMContentLoaded", function() {
  function form_add_validator($selector, $cb) {
    var $s = document.querySelectorAll($selector);
    if ($s.length > 0) {
      var $f = $s[0];

      $f.onsubmit = $cb;
    }
  }
  function error($s) {
    alert($s);
    return false;
  }

  form_add_validator(".validate-login", function() {
    if (this.login.value.length < 1) return error("Podaj login");
    if (this.password.value.length < 1) return error("Podaj hasło");
    return true;
  });

  form_add_validator(".validate-remind", function() {
    if (this.email.value.length < 1) return error("Podaj adres e-mail");
    if (!this.email.value.match(/^.+@.+\..+$/)) return error("Podaj POPRAWNY adres e-mail");
    return true;
  });

  form_add_validator(".validate-chpwd", function() {
    if (this.password.value.length < 1) return error("Podaj nowe hasło");
    if (this.password.value != this.confirm.value) return error("Hasła się nie zgadzają!");
    return true;
  });

  form_add_validator(".validate-register", function() {
    if (this.login.value.length < 1) return error("Podaj login");
    if (this.email.value.length < 1) return error("Podaj e-mail");
    if (!this.email.value.match(/^.+@.+\..+$/)) return error("Podaj POPRAWNY adres e-mail");
    if (this.password.value.length < 1) return error("Podaj hasło");
    if (this.password.value != this.confirm.value) return error("Hasła się nie zgadzają!");
    return true;
  });

  form_add_validator(".validate-epet", function() {
    if (this.firma.value.length < 1) return error("Pole firma nie może być puste");
    if (this.model.value.length < 1) return error("Pole model nie może być puste");
    if (this.opis.value.length < 11) return error("Pole opis musi być dłuższe niż 10 znaków");
    if (this.cena.value.length < 1) return error("Pole cena nie może być puste");
    if (!this.cena.value.match(/^[0-9]+(\.[0-9]{1,2})?$/)) return error("Pole cena musi być poprawną liczbą dodatnią");
    if (this.cena.value > 1000000) return error("Pole cena musi być mniejsze niż milion złotych");
    return true;
  });
})
