<?php

 class Model {
 private $host = "localhost";
 private $db_name = "test_drive";
 private $username = "root";
 private $password = "root123";
 private $conn;
 private $db_type = "mysql"; // Opções: "mysql", "pgsql", "sqlite", "mssql"
/*Dependendo do tipo de banco de dados escolhido, você pode precisar ajustar os parâmetros de conexão ($host, $db_name, $username e $password) da seguinte forma:

          MySQL:
          
          $host: Endereço do servidor MySQL (por exemplo, 'localhost' ou o IP do servidor)
          $db_name: Nome do banco de dados MySQL
          $username: Nome de usuário para acessar o banco de dados MySQL
          $password: Senha para acessar o banco de dados MySQL
          PostgreSQL:
          
          $host: Endereço do servidor PostgreSQL (por exemplo, 'localhost' ou o IP do servidor)
          $db_name: Nome do banco de dados PostgreSQL
          $username: Nome de usuário para acessar o banco de dados PostgreSQL
          $password: Senha para acessar o banco de dados PostgreSQL
          SQLite:
          
          $host: Não é necessário para SQLite, pois é um banco de dados baseado em arquivo
          $db_name: Caminho completo para o arquivo do banco de dados SQLite (por exemplo, 'my_database.sqlite')
          $username: Não é necessário para SQLite
          $password: Não é necessário para SQLite
          SQL Server (MSSQL):
          
          $host: Endereço do servidor SQL Server (por exemplo, 'localhost' ou o IP do servidor)
          $db_name: Nome do banco de dados SQL Server
          $username: Nome de usuário para acessar o banco de dados SQL Server
          $password: Senha para acessar o banco de dados SQL Server
          */

 public function __construct() {
     $this->connect();
 }

 private function connect() {
  $this->conn = null;

  try {
    switch ($this->db_type) {
        case "mysql":
          $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name;
            break;
        case "pgsql":
            $dsn = "pgsql:host=" . $this->host . ";dbname=" . $this->db_name;
            break;
        case "sqlite":
            $dsn = "sqlite:" . $this->db_name;
            break;
        case "mssql":
           $dsn = "sqlsrv:Server=" . $this->host . ";Database=" . $this->db_name;
           break;
        default:
            throw new Exception("Database type not supported.");
      }
     $this->conn = new PDO($dsn, $this->username, $this->password);
     $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $exception) {
      echo "Connection error: " . $exception->getMessage();
  } catch (Exception $exception) {
      echo $exception->getMessage();
  }
}

// a função recebe dois argumentos, 1º a tabela do banco,e 2º os dados em um array
public function create($table, $data) {
// Junta as chaves do array $data em uma única string(as colunas da tabela), separadas por vírgulas
 $columns = implode(", ", array_keys($data));
// Mapeia as chaves do array $data para criar placeholders(os dados de inserção), e junta em uma única string separada por vírgulas
 $placeholders = implode(", ", array_map(function($item) {
     return ":$item"; 
 }, array_keys($data)));

// Cria a query SQL de inserção com o nome da tabela, colunas e placeholders
 $query = "INSERT INTO $table ($columns) VALUES ($placeholders)";
// Prepara a query SQL para execução
 $stmt = $this->conn->prepare($query);

// Vincula os valores do array $data aos respectivos placeholders na query
  foreach ($data as $key => $value) {
      $stmt->bindValue(":$key", $value);
  }

// Executa a query e retorna o resultado (true para sucesso, false para falha)
    return $stmt->execute();
}

// a função recebe dois argumentos, a tabela do banco, e a condição em formato de array
public function read($table, $conditions = []) {
// Cria a query SQL de seleção com o nome da tabela
$query = "SELECT * FROM $table";

// Verifica se o array $conditions não está vazio
 if (!empty($conditions)) {
// Mapeia as chaves do array $conditions para criar condições, e junta em uma única string separada por 'AND'
    $conditionsStr = implode(" AND ", array_map(function($item) {
       return "$item = :$item";
       }, array_keys($conditions)));
// Adiciona a cláusula WHERE com as condições à query SQL
    $query .= " WHERE $conditionsStr";
}

// Prepara a query SQL para execução
$stmt = $this->conn->prepare($query);

// Vincula os valores do array $conditions aos respectivos placeholders na query
foreach ($conditions as $key => $value) {
    $stmt->bindValue(":$key", $value);
}

// Executa a query
 $stmt->execute();

// Retorna todos os registros encontrados como um array associativo
   return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// a função recebe três argumentos, 1º a tabela do banco,e 2º os dados em um array e 3º a condição
public function update($table, $data, $conditions) {
 // Mapeia as chaves do array $data para criar atribuições e junta em uma única string separada por vírgulas
$dataStr = implode(", ", array_map(function($item) {
    return "$item = :$item"; 
}, array_keys($data)));
// Mapeia as chaves do array $conditions para criar condições e junta em uma única string separada por 'AND'
$conditionsStr = implode(" AND ", array_map(function($item) { 
    return "$item = :condition_$item"; 
 }, array_keys($conditions)));
// Cria a query SQL de atualização com o nome da tabela, atribuições e condições
$query = "UPDATE $table SET $dataStr WHERE $conditionsStr";
// Prepara a query SQL para execução
$stmt = $this->conn->prepare($query);

// Vincula os valores do array $data aos respectivos placeholders na query
foreach ($data as $key => $value) {
    $stmt->bindValue(":$key", $value);
 }

// Vincula os valores do array $conditions aos respectivos placeholders na query
foreach ($conditions as $key => $value) {
    $stmt->bindValue(":condition_$key", $value);
 }

// Executa a consulta e retorna o resultado (true em caso de sucesso, false em caso de falha)
   return $stmt->execute();
}

// a função recebe dois argumentos, 1º a tabela do banco,e 2º a condição
public function delete($table, $conditions) {
  // Mapeia as chaves do array $conditions para criar condições e junta em uma única string separada por 'AND'
$conditionsStr = implode(" AND ", array_map(function($item) {
  return "$item = :$item"; 
  }, array_keys($conditions)));

// Cria a consulta SQL de exclusão com o nome da tabela e condições
$query = "DELETE FROM $table WHERE $conditionsStr";
// Prepara a consulta SQL para execução
$stmt = $this->conn->prepare($query);

// Vincula os valores do array $conditions aos respectivos placeholders na consulta
foreach ($conditions as $key => $value) {
   $stmt->bindValue(":$key", $value);
 }
// Executa a consulta e retorna o resultado (true em caso de sucesso, false em caso de falha)
  return $stmt->execute();
  }
}
