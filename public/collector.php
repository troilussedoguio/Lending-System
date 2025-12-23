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

$fetchCollector = $uc->fetchCollector();

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

include "../views/collector.php";
?>
