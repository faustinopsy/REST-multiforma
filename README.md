# Projeto API CRUD
Este repositório contém um projeto simples de API CRUD que permite a criação, leitura, atualização e exclusão de usuários. O projeto está disponível em duas versões diferentes, cada uma em sua própria branch:

A branch main contém a versão do projeto que NÃO segue a PSR-4, para os exemplos com PSR veja as branchs desse projeto, há no minimo 4 branchs com formatos diferentes.
As branchs (com_psr) contém a versão do projeto que segue a PSR-4.
PSR-4
A PSR-4 é uma recomendação da PHP-FIG que define um padrão de autoloading de classes que permite a interoperabilidade de código entre diferentes projetos e suas bibliotecas.

## Vantagens de usar PSR-4
Interoperabilidade: Facilita a reutilização de código em diferentes projetos.
Autoloading de Classes: Não é necessário incluir manualmente os arquivos de classes.
Estrutura de Diretórios Clara: A estrutura de diretórios e namespaces é clara e intuitiva.
Desvantagens de usar PSR-4
Curva de Aprendizado: Pode ser um pouco difícil para novos desenvolvedores se acostumarem com o padrão.
Configuração Adicional: Requer alguma configuração adicional no arquivo composer.json.
## Como usar a PSR-4
Para usar a PSR-4, você precisa configurar o autoloading no seu arquivo composer.json. Por exemplo:

 ```sh
{
    "autoload": {
        "psr-4": {
            "App\\": "backend/"
        }
    }
}
 ```
e dentro dos arquivos precisa-se incluir o namespace

por exemplo:
```sh
namespace App\User;

class User {
    // código da classe
}
 ```

 e para usar no arquivo principal:
```sh
 require 'vendor/autoload.php';

use App\User;
 ```
 
Depois, execute o comando composer install para gerar o arquivo vendor/autoload.php.
assim agora cria-se uma pasta vendor na raiz do projeto que é responsável por saber onde está as classes
## Exemplo de Uso
Este projeto é uma API simples que permite criar, ler, atualizar e excluir usuários.

## Rotas
GET /backend/usuario/{id}: Recupera um usuário pelo ID.
GET /backend/usuario: Recupera todos os usuários.
POST /backend/usuario: Cria um novo usuário.
PUT /backend/usuario/{id}: Atualiza um usuário existente pelo ID.
DELETE /backend/usuario/{id}: Exclui um usuário pelo ID.
## Inicialização
Para iniciar o projeto, siga estas etapas:

Clone o repositório.
Instale as dependências com composer install.
Inicie o servidor com php -S localhost:8000.


## Autor

Nome do Autor
- [Github](https://github.com/faustinopsy)
- [LinkedIn](https://www.linkedin.com/in/faustinopsy)

## Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
