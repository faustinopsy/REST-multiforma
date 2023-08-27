<?php
//require_once 'Model.php';
require_once 'User.php';

class UserManager {

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
    private $database = [
        ['id'=>1,'nome'=>'Teste 1 array 1'],
        ['id'=>2,'nome'=>'Teste 2 array 2'],
        ['id'=>3,'nome'=>'Teste 3 array 3'],
        ['id'=>4,'nome'=>'Teste 4 array 4'],
        ['id'=>5,'nome'=>'Teste 5 array 5'],
        ['id'=>6,'nome'=>'Teste 6 array 6'],
        ['id'=>7,'nome'=>'Teste 7 array 7'],
        ['id'=>8,'nome'=>'Teste 8 array 8'],
        ['id'=>9,'nome'=>'Teste 9 array 9'],
        ['id'=>10,'nome'=>'Teste 10 array 10'],
    ];
    

    public function __construct() {

    }


    public function getUserById($id) {
        foreach ($this->database as $userData) {
            if ($userData['id'] == $id) {
                $user = new User();
                $user->setId($userData['id']);
                $user->setNome($userData['nome']);
                return $user;
            }
        }
    
        return false;
    }
    

    public function getAllUsers() {
        $users = [];

        foreach ($this->database as $userData) {
            $user = new User();
            $user->setId($userData['id']);
            $user->setNome($userData['nome']);
            $users[] = $user->toArray();
        }
        return $users;
    }

    public function createUser($data) {
        $resultado= $this->database;
        if(!empty($resultado)){
            if($resultado[0]["nome"]==$data['nome']){
                return false;
            }
        }
        if(!empty($data)){
            $user = new User();
            $user->setNome($data["nome"]);
            $maxId = max(array_column($this->database, 'id'));
            $newId = $maxId + 1;
            $this->database[] = ['id' => $newId, 'nome' => $data["nome"]];
            return true;
        }else{
            return false;
        }
        
       
    }

    public function updateUser($id, $data) {
        foreach ($this->database as &$userData) {
            if ($userData['id'] == $id) {
                $userData['nome'] = $data["nome"];
                $user = new User();
                $user->setId($id);
                $user->setNome($data["nome"]);
                return $user;
            }
        }
        return false;
    }

    public function deleteUser($id) {
        foreach ($this->database as $index => $userData) {
            if ($userData['id'] == $id) {
                unset($this->database[$index]);
                return true;
            }
        }
        return false;
    }
    public function generateToken() {
        //return bin2hex(openssl_random_pseudo_bytes(16));
        return $this->tokens[rand(1,11)];
    }
    public function isValidToken($token) {
        return in_array($token, $this->tokens);
    }
    
}
