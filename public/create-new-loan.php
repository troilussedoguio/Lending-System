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
$LoansController = new LoansController($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'):
    $output = $LoansController->createLoans($_POST);

    echo json_encode($output);
    exit;
endif;

if(isset($_GET['id']) && !empty($_GET['id'])){
    
    $editLoans = $LoansController->editLoans($_GET['id']);
    
    if (!$editLoans['id']) {
        header("Location: create-new-loan");
        exit();  // Ensure no further code is executed after the redirect
    }

}


$UserController = new UserController($db);
$fetchBarrower = $UserController->fetchBarrower();
$fetchCollector = $UserController->fetchCollector();
$p = $LoansController->fetchPercentage();
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

include "../views/create-new-loan.php";
?>
