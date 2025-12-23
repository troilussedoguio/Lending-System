<?php
require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\LoansController;
use controllers\UserController;


$db = (new Database())->connect();
$lc = new LoansController($db);
$uc = new UserController($db);


$fetchCollector = $lc->fetchDueDate();
include '../views/due-date.php';
?>