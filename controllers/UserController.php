<?php

namespace controllers;

use models\User;

class UserController {
    
    private $userModel;

    public function __construct($db) {
        $this->userModel = new User($db) ;
    }

    // Create new user
    public function createUser($form) {
        return $this->userModel->create($form);
    }
    
    // Fetch users
    public function fetchBarrower() {
        return $this->userModel->getBarrower();
    }

    public function fetchCollector() {
        return $this->userModel->getCollector();
    }

    public function fetchUser($id) {
        return $this->userModel->specificUser($id);
    }

    public function deleteUserImg($id) {
        return $this->userModel->deleteUserImgs($id);
    }
    public function deleteUserInfo($data) {
        return $this->userModel->deleteUsers($data);
    }

    public function auth($data){
        return $this->userModel->login($data);
    }
}
