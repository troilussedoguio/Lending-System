<?php

require_once __DIR__ . "/../../bootstrap.php";

use config\Database;
use controllers\LoansController;


$db = (new Database())->connect();
$lc= new LoansController($db);
if ($_SERVER['REQUEST_METHOD'] === "POST") {

    $uw = $lc->updateWeekly($_POST);

    echo json_encode($uw);
    exit;
}
?>