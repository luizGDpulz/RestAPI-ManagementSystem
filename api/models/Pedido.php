<?php
class Pedido {
    private $conn;
    private $table = "pedidos";

    public $id;
    public $cliente_id;
    public $descricao;
    public $valor;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Criar pedido
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                SET cliente_id = :cliente_id, 
                    descricao = :descricao, 
                    valor = :valor, 
                    status = :status";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":cliente_id", $this->cliente_id);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":status", $this->status);

        return $stmt->execute();
    }

    // Ler todos os pedidos
    public function read() {
        $query = "SELECT p.*, c.nome as cliente_nome 
                FROM " . $this->table . " p
                LEFT JOIN clientes c ON p.cliente_id = c.id
                ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    // Ler um pedido
    public function readOne() {
        $query = "SELECT p.*, c.nome as cliente_nome 
                FROM " . $this->table . " p
                LEFT JOIN clientes c ON p.cliente_id = c.id
                WHERE p.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualizar pedido
    public function update() {
        $query = "UPDATE " . $this->table . "
                SET cliente_id = :cliente_id,
                    descricao = :descricao,
                    valor = :valor,
                    status = :status
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":cliente_id", $this->cliente_id);
        $stmt->bindParam(":descricao", $this->descricao);
        $stmt->bindParam(":valor", $this->valor);
        $stmt->bindParam(":status", $this->status);
        $stmt->bindParam(":id", $this->id);

        return $stmt->execute();
    }

    // Deletar pedido
    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        return $stmt->execute();
    }

    // Ler pedidos por cliente
    public function readByCliente($cliente_id) {
        $query = "SELECT p.*, c.nome as cliente_nome 
                FROM " . $this->table . " p
                LEFT JOIN clientes c ON p.cliente_id = c.id
                WHERE p.cliente_id = ?
                ORDER BY p.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $cliente_id);
        $stmt->execute();

        return $stmt;
    }
} 