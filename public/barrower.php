<?php
require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\UserController;

$db = (new Database())->connect();
$uc = new UserController($db);

$fetchBarrower = $uc->fetchBarrower();

include "../views/barrower.php";
?>
