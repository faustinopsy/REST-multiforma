<?php
namespace App\Controller;

use App\Model\Model;
use App\User\User;

class UserController {

    protected $model;
	
	
	private $tokens = [
        'd09f7c370a88944e1e3d233f285e533dbf0736040aa79de1a2e8a8ffb570b6cf',
        'ae350ddaa07597c8eecf02e1f60da88014caef07da5fb547fecdb5f3e15d8cf8',
        '5f9c96696dcec2aafc9e6f9017a433088fdaa110388c70ad02f20b91e6a1550c',
        'e4b0a64a269ca988f4607310abe06fb2c165d8f357cc3d98d71f13753c55e73d',
        '87c60b31497b9c9cae514962d3e4ab2539841ae2a67886cd9b522475c89f874e',
        '76c99ea987e9a3ebbdc6575c3f2149e6105ed284c045a5e00d4a3917fb3a1084',
        'fa6c90a0791318bfd36597cc85e987de47b3efb966185d368d87728413bdf8ed',
        '05846d1f88d82e0b7fa474cc2ddf4b3ab341a97d108abcbd59e3de40a69654da',
        '66a0c7bcbfab9c4498f9c7f7998b6fa869db6383294be5ee9619c13c5e8aff5b',
        '8f2e85344124acb26a117d279d9697ce0a47bc745d2afa119e1f909eb3168a44',
        '51753a0769fc6f4e53d5790df9b42325139167778e35ab9ef86bf74cba020554',
        '8f396973867b1260611632e49a315ea3cef3247168e280e4e0dbc67f7930c9cc',
    ];
    public function __construct() {
        $this->model = new Model();
    }

    public function getUserById($id) {
        $data = $this->model->read('users', ['id' => $id]);
        if (!empty($data)) {
            $users=[];
            $user = new User();
            $user->setId($data[0]['id']);
            $user->setNome($data[0]['nome']);
            $users=['id'=>$user->getId(),'nome'=>$user->getNome()];
        return $users;
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
            $users[]=['id'=>$user->getId(),'nome'=>$user->getNome(),'type'=>$user->getType()];
        }

        return $users;
    }

    public function createUser($data) {
        $resultado= $this->model->read('users', ['nome' => $data['nome']]);
        if(!empty($resultado)){
            if($resultado[0]["nome"]==$data['nome']){
                return false;
            }
        }
        $user = new User();
        $user->setNome($data["nome"]);
        $user->setSenha('123456');
        $this->model->create('users', ['nome' => $user->getNome(),'senha' => $user->getSenha()]);
        $id_user = $this->model->getLastInsertId();
        return  $id_user;
    }

    public function updateUser($id, $data) {
        $resultado=$this->getUserById($id);
        if(!$resultado){
            return false;
        }
        $user = new User();
        $user->setId($id);
        $user->setNome($data["nome"]);
        $user->setSenha('123456');
        $sucesso= $this->model->update('users', ['nome' => $user->getNome(),'senha' => $user->getSenha()], ['id' => $user->getId()]);
        if(!$sucesso){
            return false;
        }
        return true;
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

    public function generateToken() {
        return bin2hex(openssl_random_pseudo_bytes(16));
        //return $this->tokens[rand(1,12)];
    }
    public function isValidToken($token) {
        $resultado= $this->model->read('token', ['token' => $token]);
        return $resultado;
    }
    function verificarToken() {
        $headers = getallheaders();
        $token = $headers['Authorization'] ?? null;
        if ($token === null || !$this->isValidToken($token)) {
            return false;
        }
        return true;
    }
}
