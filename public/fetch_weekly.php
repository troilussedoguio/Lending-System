<?php
require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\LoansController;

if($_SERVER['REQUEST_METHOD'] === "POST"){
$db = (new Database())->connect();
$controller = new LoansController($db);

    $fetchLoans = $controller->weeklyPayment($_POST);
    
    echo json_encode($fetchLoans);
}else{
    header("HTTP/1.1 403 Forbidden");
}
?>
