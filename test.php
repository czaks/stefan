<?php
require_once("lib/core.php");
db_init();

echo render("layout", ["content" => "Hello world!!!"]);

echo "<pre>";

$users = User::all();

var_dump($users);

$user = $users[0];

var_dump($user);

$user->set_password("testtest");
$user->save();

var_dump($user);

var_dump($user->check_password("testtest"));
var_dump($user->check_password("test"));


$user = new User;

$user->email = "bezmalpy";
var_dump($user->save());

$user->email = "stefan@sobczak.pl";
$user->login = "Stefan";
var_dump($user->save());

$user->set_password("januszkorwin123mielone");
var_dump($user->save());
