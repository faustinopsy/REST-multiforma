<?php
require_once 'Users.php';
require_once 'AdminUser.php';

class UserManager {

    public function getUserById($id) {
        return new User($id, 'Carlos');  
    }

    public function getAllUsers() {
        $users = [
            new User(1, 'Carlos'),
            new User(2, 'Ana'),
            new User(3, 'Roberto'),
            new User(4, 'Maria')
        ];
        $usuariosArray = array_map(function($users) {
            return $users->toArray();
        }, $users);
        return $usuariosArray;
    }

    public function createUser($nome) {
        return new User(2, $nome); 
    }

    public function updateUser($id, $nome) {
        $user = $this->getUserById($id);  
        $user->setNome($nome);
        return $user->getId();
    }

    public function deleteUser($id) {
        
        return true;
    }

    
    public function createAdmin($nome, $privileges) {
        return new AdminUser(5, $nome, $privileges); 
    }
}
