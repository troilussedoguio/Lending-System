<?php
require "../config/Database.php";
require "../models/User.php";
require "../controllers/UserController.php";

$db = (new Database())->connect();
$c = new UserController($db);

$c->destroy($_GET['id']);

header("Location: index.php");
