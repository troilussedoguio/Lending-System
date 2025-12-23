<?php
require_once __DIR__ . '/../bootstrap.php';

if (!isset($_SESSION['data']['id']) || empty($_SESSION['data']['id'])) {
   header("Location: auth");
   exit;
}
use config\Database;
use controllers\UserController;

$db = (new Database())->connect();
$controller = new UserController($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'):
    
    if(isset($_POST['method']) && !empty($_POST['method'])):
        
        $deleted = $controller->deleteUserInfo($_POST);
        echo json_encode($deleted);
    else:
        if(isset($_POST['methods']) && $_POST['methods'] === 'delete'):

            $id = $_POST['id'];
            
            $deleted = $controller->deleteUserImg($id);
            echo json_encode($deleted);

        else:
            $inserted = $controller->createUser($_POST);
            echo json_encode($inserted);
        endif;
    endif;
    exit;
endif;

if(isset($_GET['id']) && !empty($_GET['id'])):
    
    $edit = $controller->fetchUser($_GET['id']);
    if (!$edit['id']) {
        header("Location: add-new-barrower");
        exit(); 
    }
endif;

$_SESSION['csrf_token'] = bin2hex(random_bytes(32)); 
include "../views/add-new-barrower.php";
?>
