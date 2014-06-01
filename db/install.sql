DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id		integer primary key not null,
  login		varchar(50)         not null,
  email		varchar(255)        not null,
  password	varchar(50)         not null,
  admin		bool                not null default 0,
  confirmed	bool		    not null default 0,
  confirm_hash   varchar(50),
  recovery      varchar(50)
);

INSERT INTO users
  (id,   login,  password,                             email,          admin, confirmed)
VALUES     -- hasło: test
  (null, "test", "$1$testtest$SpO/FHIMn8I1fYKuRHVWW1", "test@test.pl",     1,         1);


DROP TABLE IF EXISTS epety;

CREATE TABLE epety (
  id		integer primary key not null,
  firma varchar(255) not null,
  model varchar(255) not null,
  opis text not null,
  cena double(10,2) not null,
  opinia text
);

INSERT INTO epety
  (id, firma, model, opis, cena, opinia)
VALUES
  (NULL, 'HCIGAR', 'Kayfun',
    'Kayfun w wersji 3.1 posiada regulację przepływu powietrza, która odbywa się za pomocą śrubki wkręconej w bok obudowy.
    Im bardziej wkręcimy śrubkę, tym mniejszy jest dopływ powietrza. ',  '120.00', ' dobry sprzęt'),
  (NULL, 'HCIGAR', 'Kayfun2',
    'Kayfun w wersji 3.1 posiada regulację przepływu powietrza, która odbywa się za pomocą śrubki wkręconej w bok obudowy.
    Im bardziej wkręcimy śrubkę, tym mniejszy jest dopływ powietrza. ',  '120.00', ' dobry sprzęt'),
  (NULL, 'HCIGAR', 'Kayfun3',
    'Kayfun w wersji 3.1 posiada regulację przepływu powietrza, która odbywa się za pomocą śrubki wkręconej w bok obudowy.
    Im bardziej wkręcimy śrubkę, tym mniejszy jest dopływ powietrza. ',  '120.00', ' dobry sprzęt'),
  (NULL, 'HCIGAR', 'Kayfun4',
    'Kayfun w wersji 3.1 posiada regulację przepływu powietrza, która odbywa się za pomocą śrubki wkręconej w bok obudowy.
    Im bardziej wkręcimy śrubkę, tym mniejszy jest dopływ powietrza. ',  '120.00', ' dobry sprzęt'),
  (NULL, 'HCIGAR', 'Kayfun5',
    'Kayfun w wersji 3.1 posiada regulację przepływu powietrza, która odbywa się za pomocą śrubki wkręconej w bok obudowy.
    Im bardziej wkręcimy śrubkę, tym mniejszy jest dopływ powietrza. ',  '120.00', ' dobry sprzęt')
