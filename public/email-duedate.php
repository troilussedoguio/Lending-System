<?php

//this page is for cron job to send email reminders for due dates can be run only in cli mode or via cron job
if (php_sapi_name() !== 'cli') {
    header("HTTP/1.1 403 Forbidden");
    exit;
}

require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\LoansController;

$db = (new Database())->connect();
$controller = new LoansController($db);
$sendEmail = $controller->sendDueDates();
?>
