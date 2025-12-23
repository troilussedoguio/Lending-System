<?php

require_once __DIR__ . '/../bootstrap.php';

use config\Database;
use controllers\UserController;

$db = (new Database())->connect();
$u = new UserController($db);

if($_SERVER['REQUEST_METHOD'] === "POST"):

    $auth = $u->auth($_POST);
    echo json_encode($auth);
    exit;

endif;
include "../views/auth.php";
?>
