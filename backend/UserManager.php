<?php
require_once 'Model.php';
require_once 'User.php';

class UserManager {

    protected $model;

    public function __construct() {
        $this->model = new Model();
    }

    public function getUserById($id) {
        $data = $this->model->read('users', ['id' => $id]);
        if (!empty($data)) {
            $user = new User();
            $user->setId($data[0]['id']);
            $user->setNome($data[0]['nome']);
            return $user;
        } else {
            return false;
        }
    }

    public function getAllUsers() {
        $data = $this->model->read('users');
        $users = [];

        foreach ($data as $userData) {
            $user = new User();
            $user->setId($userData['id']);
            $user->setNome($userData['nome']);
            $users[] = $user;
        }

        return $data;
    }

    public function createUser($data) {
        $resultado= $this->model->read('users', ['nome' => $data['nome']]);
        if(!empty($resultado)){
            if($resultado[0]["nome"]==$data['nome']){
                return false;
            }
        }
        if(!empty($data)){
            $user = new User();
            $user->setNome($data["nome"]);
            $sucesso= $this->model->create('users', ['nome' => $user->getNome()]);
            return $sucesso;
        }else{
            return false;
        }
        
       
    }

    public function updateUser($id, $data) {
        $resultado=$this->getUserById($id);
        if(!$resultado){
            return false;
        }
        $user = new User();
        $user->setId($id);
        $user->setNome($data["nome"]);
        return $this->model->update('users', ['nome' => $user->getNome()], ['id' => $user->getId()]);
    }

    public function deleteUser($id) {
        $resultado=$this->getUserById($id);
        if(!$resultado){
            return false;
        }
        $user = new User();
        $user->setId($id);
        return $this->model->delete('users', ['id' => $user->getId()]);
    }

}
