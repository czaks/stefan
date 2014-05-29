DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id		int(11) primary key,
  login		varchar(50)         not null,
  email		varchar(255)        not null,
  password	varchar(50)         not null,
  admin		bool                not null,
  confirmed	bool		    not null,
  recovery      varchar(50)
);

INSERT INTO users
  (id,   login,  password,                             email,          admin, confirmed)
VALUES     -- hasło: test
  (null, "test", "$1$testtest$SpO/FHIMn8I1fYKuRHVWW1", "test@test.pl",     1,         1);
