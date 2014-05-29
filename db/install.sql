CREATE TABLE users (
  id		int(11) primary key not null,
  login		varchar(50)         not null,
  email		varchar(255)        not null,
  password	varchar(50)         not null,
  admin		bool                not null,
  recovery      varchar(50)
);

INSERT INTO users
  (login,  password,                             email,          admin, confirmed)
VALUES     -- hasło: test
  ("test", "$1$testtest$SpO/FHIMn8I1fYKuRHVWW1", "test@test.pl",     1,         1);


