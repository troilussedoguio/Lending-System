<?php
require "../config/Database.php";
require "../models/User.php";
require "../controllers/UserController.php";

$db = (new Database())->connect();
$controller = new UserController($db);

$controller->store($_POST);

header("Location: index.php");
