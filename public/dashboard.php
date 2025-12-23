<?php
require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\LoansController;

$db = (new Database())->connect();
$c = new LoansController($db);

$r = $c->dashboardCards();

include "../views/dashboard.php";
?>
