<?php
require_once __DIR__ . '/../../bootstrap.php';

use config\Database;
use controllers\LoansController;

$db = (new Database())->connect();
$c = new LoansController($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'):
    
    $i = $c->savePercentage($_POST);
    
    echo json_encode($i);
    exit;
endif;


// $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Generate a random 32-byte token

?>
