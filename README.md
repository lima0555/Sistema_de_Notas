# EasyNotes - Sistema de Gerenciamento de Notas

![PHP](https://img.shields.io/badge/PHP-777B96?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)

## Visão Geral do Projeto

O EasyNotes é um sistema de gerenciamento de notas simples e eficiente, desenvolvido com PHP e MySQL. O objetivo principal é fornecer uma plataforma pessoal para que os usuários possam criar, organizar, editar e excluir notas de forma intuitiva, com a funcionalidade de filtro por categoria.

Este projeto é uma demonstração completa do ciclo **CRUD** (Create, Read, Update, Delete), que é a base de muitas aplicações web.

## Funcionalidades Principais

* **Autenticação de Usuário**: Sistema de login e verificação de sessão para garantir que apenas usuários logados possam acessar e gerenciar suas notas.
* **Gestão de Notas**:
    * **Criar**: Crie novas notas com título, conteúdo e categoria.
    * **Visualizar**: A tela inicial exibe todas as notas do usuário logado.
    * **Editar**: Permite a modificação de notas existentes através de um formulário pré-preenchido.
    * **Excluir**: Exclusão segura de notas com uma verificação de propriedade para evitar que usuários apaguem notas de terceiros.
* **Organização por Categoria**: As notas podem ser filtradas por categorias como "Estudos", "Trabalho", "Compras" e "Geral".
* **Design Responsivo**: O design da interface é simples e intuitivo.

## Tecnologias Utilizadas

* **PHP**: Linguagem de back-end para processar a lógica da aplicação, gerenciar sessões e interagir com o banco de dados.
* **MySQL**: Sistema de gerenciamento de banco de dados para armazenar informações de usuários e notas.
* **HTML5/CSS3**: Estrutura e estilização da interface de usuário.
* **Git/GitHub**: Controle de versão e hospedagem do código-fonte.

## Como Executar o Projeto Localmente

Siga estes passos para configurar e executar o projeto em sua máquina:

1.  **Pré-requisitos**: Certifique-se de ter um ambiente de desenvolvimento local, como o **XAMPP** ou **WAMP**, com PHP e MySQL instalados e funcionando.

2.  **Clone o Repositório**:
    ```bash
    git clone [https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git](https://github.com/SEU_USUARIO/SEU_REPOSITORIO.git)
    ```
    (Substitua `SEU_USUARIO` e `SEU_REPOSITORIO` pelo seu nome de usuário e pelo nome do seu repositório).

3.  **Configurar o Banco de Dados**:
    * Abra o **phpMyAdmin** ou outra ferramenta de gerenciamento de banco de dados.
    * Crie um novo banco de dados chamado `sistemas_usuarios`.
    * Execute os seguintes comandos SQL para criar as tabelas necessárias:
        
        ```sql
        -- Tabela para armazenar os usuários
        CREATE TABLE usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );

        -- Tabela para armazenar as notas
        CREATE TABLE notas (
            id INT AUTO_INCREMENT PRIMARY KEY,
            titulo VARCHAR(255) NOT NULL,
            conteudo TEXT NOT NULL,
            usuario_id INT NOT NULL,
            categoria VARCHAR(50),
            data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
        );
        ```

4.  **Configurar a Conexão**:
    * Abra o arquivo `entrada/conexao.php`.
    * Verifique se as credenciais de acesso ao seu banco de dados (`$servername`, `$username`, `$password`, `$dbname`) estão corretas.

5.  **Acessar a Aplicação**:
    * Inicie o servidor Apache no seu XAMPP.
    * Abra seu navegador e acesse a URL: `http://localhost/SEU_REPOSITORIO/`
    * Selecione a opção de login ou de cadastro e comece a usar o EasyNotes!
