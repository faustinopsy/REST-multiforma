<?php

class User {
    private $id;
    private $nome;

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

    public function toArray() {
        return ['id' => $this->getId(), 'nome' => $this->getNome(), 'type' => $this->getType()];
    }
}
