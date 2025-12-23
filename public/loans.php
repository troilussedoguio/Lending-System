<?php
require_once __DIR__.'/../autoload.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}

use config\Database;
use controllers\LoansController;

$db = (new Database())->connect();
$controller = new LoansController($db);

$fetchLoans = $controller->fetchLoans();

if($_SERVER['REQUEST_METHOD'] == 'POST'):

    if(isset($_POST['loan_id']) && !empty($_POST['loan_id'])):
            $deleted = $controller->deleteLoanInfos($_POST);
            echo json_encode($deleted);
            exit;
    endif;
endif;

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
include "../views/loans.php";
?>
