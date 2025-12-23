<?php
require "../config/Database.php";
require "../models/User.php";
require "../controllers/UserController.php";

$db = (new Database())->connect();
$c = new UserController($db);
$user = $c->edit($_GET['id']);

include "../views/edit.php";
