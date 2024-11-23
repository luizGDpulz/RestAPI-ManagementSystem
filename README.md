# 🚀 API REST - Sistema de Gestão de Clientes e Pedidos

Uma API REST completa para gerenciamento de clientes e pedidos, desenvolvida em PHP com interface web em Bootstrap.

## 📋 Índice

- [Recursos](#-recursos)
- [Tecnologias](#-tecnologias) 
- [Instalação](#-instalação)
- [Estrutura do Projeto](#-estrutura-do-projeto)
- [Endpoints da API](#-endpoints-da-api)
- [Interface Web](#-interface-web)
- [Contribuição](#-contribuição)

## 💫 Recursos

- ✅ CRUD completo de Clientes
- ✅ CRUD completo de Pedidos  
- ✅ Interface web responsiva
- ✅ Validações de dados
- ✅ Relacionamentos entre entidades
- ✅ Documentação completa

## 🛠 Tecnologias

- ![PHP](https://img.shields.io/badge/PHP-777BB4?style=flat&logo=php&logoColor=white) PHP 7.4+
- ![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=flat&logo=mysql&logoColor=white) MySQL
- ![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=flat&logo=bootstrap&logoColor=white) Bootstrap 5
- ![jQuery](https://img.shields.io/badge/jQuery-0769AD?style=flat&logo=jquery&logoColor=white) jQuery
- ![DataTables](https://img.shields.io/badge/DataTables-1.11.5-blue) DataTables

## 📦 Instalação

### Pré-requisitos

- XAMPP instalado (Apache + MySQL + PHP)
- Git (opcional)

### Passo a Passo

1. **Iniciar o XAMPP**
    ```bash
    # Inicie o Apache e MySQL no XAMPP Control Panel
    ```
2. **Clonar o Repositório**
    ```bash
    # Na pasta htdocs do XAMPP

    cd C:\xampp\htdocs
    git clone [url-do-repositorio]

    # Ou baixe e extraia o ZIP do projeto
    ```
3. **Criar o Banco de Dados**
    ```SQL
    -- Acesse http://localhost/phpmyadmin
    -- Execute o SQL:

    CREATE DATABASE api_rest;
    USE api_rest;

    CREATE TABLE clientes (
        id INT PRIMARY KEY AUTO_INCREMENT,
        nome VARCHAR(100) NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        telefone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );

    CREATE TABLE pedidos (
        id INT PRIMARY KEY AUTO_INCREMENT,
        cliente_id INT NOT NULL,
        descricao TEXT NOT NULL,
        valor DECIMAL(10,2) NOT NULL,
        status ENUM('pendente', 'aprovado', 'cancelado') DEFAULT 'pendente',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (cliente_id) REFERENCES clientes(id)
    );
    ```

4. **Configurar o Projeto**
    ```bash
    # Edite config/Database.php se necessário

    private $host = "localhost";
    private $db_name = "api_rest";
    private $username = "root";
    private $password = "";
    ```

5. **Acessar o Sistema**
- API: `http://localhost/api/`
- Interface: `http://localhost/sistema/`

## 📁 Estrutura do Projeto
```
projeto/
├── api/                    # Backend - API REST
│   ├── config/             # Configurações
│   ├── controllers/        # Controladores
│   ├── models/             # Modelos
│   ├── .htaccess           # Configurações Apache
│   └── index.php           # Entrada da API
└── sistema/                # Frontend - Interface Web
    ├── js/                 # Scripts JavaScript
    └── index.html          # Página principal
```
## 🔌 Endpoints da API

### Clientes

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/clientes` | Lista todos os clientes |
| GET | `/api/clientes/{id}` | Obtém um cliente específico |
| POST | `/api/clientes` | Cria um novo cliente |
| PUT | `/api/clientes/{id}` | Atualiza um cliente |
| DELETE | `/api/clientes/{id}` | Remove um cliente |

### Pedidos

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| GET | `/api/pedidos` | Lista todos os pedidos |
| GET | `/api/pedidos/{id}` | Obtém um pedido específico |
| POST | `/api/pedidos` | Cria um novo pedido |
| PUT | `/api/pedidos/{id}` | Atualiza um pedido |
| DELETE | `/api/pedidos/{id}` | Remove um pedido |

## 💻 Interface Web

A interface web oferece:
- Dashboard intuitivo
- Gestão de clientes
- Gestão de pedidos
- Tabelas com ordenação e busca
- Formulários de cadastro e edição
- Design responsivo

## 🤝 Contribuição

1. Faça um Fork do projeto
2. Crie uma Branch para sua Feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a Branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request

## 📝 Licença

Este projeto está sob a licença CC-BY-SA-4.0 license. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## 📧 Contato

Luiz Gustavo Dias Pulz - [luizgustavodiaspulzoficial@gmail.com](mailto:luizgustavodiaspulzoficial@gmail.com)

Link do Projeto: [RestAPI-ManagementSystem](https://github.com/luizGDpulz/RestAPI-ManagementSystem.git)

---

⭐️ From [luizGDpulz](https://github.com/luizGDpulz)
