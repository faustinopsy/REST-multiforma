<?php

class User {
    private $id;
    private $nome;
    private $senha;
    public function __construct() {
      
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getType() {
        return 'User';
    }
    public function setSenha($senha) {
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }
    public function getSenha() {
        return $this->senha;
    }
    public function toArray() {
        return ['id' => $this->getId(), 'nome' => $this->getNome(), 'type' => $this->getType()];
    }
}
