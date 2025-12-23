<?php
require "../config/Database.php";
require "../models/User.php";
require "../controllers/UserController.php";

$db = (new Database())->connect();
$c = new UserController($db);

$c->update($_GET['id'], $_POST);

header("Location: index.php");
