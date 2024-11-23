<?php
class PedidoController {
    private $db;
    private $pedido;

    public function __construct($db) {
        $this->db = $db;
        $this->pedido = new Pedido($db);
    }

    // Criar novo pedido
    public function create($data) {
        if (!$this->validaCliente($data['cliente_id'])) {
            return ["error" => "Cliente não encontrado"];
        }

        $this->pedido->cliente_id = $data['cliente_id'];
        $this->pedido->descricao = $data['descricao'];
        $this->pedido->valor = $data['valor'];
        $this->pedido->status = $data['status'] ?? 'pendente';

        if($this->pedido->create()) {
            return ["message" => "Pedido criado com sucesso", "status" => 201];
        }
        return ["error" => "Erro ao criar pedido", "status" => 500];
    }

    // Buscar todos os pedidos
    public function getAll() {
        $stmt = $this->pedido->read();
        $pedidos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($pedidos, $row);
        }

        return $pedidos;
    }

    // Buscar pedido por ID
    public function getById($id) {
        $this->pedido->id = $id;
        $pedido = $this->pedido->readOne();

        if($pedido) {
            return $pedido;
        }
        return ["error" => "Pedido não encontrado", "status" => 404];
    }

    // Atualizar pedido
    public function update($id, $data) {
        $this->pedido->id = $id;
        
        if(!$this->pedido->readOne()) {
            return ["error" => "Pedido não encontrado", "status" => 404];
        }

        $this->pedido->cliente_id = $data['cliente_id'] ?? $this->pedido->cliente_id;
        $this->pedido->descricao = $data['descricao'] ?? $this->pedido->descricao;
        $this->pedido->valor = $data['valor'] ?? $this->pedido->valor;
        $this->pedido->status = $data['status'] ?? $this->pedido->status;

        if($this->pedido->update()) {
            return ["message" => "Pedido atualizado com sucesso"];
        }
        return ["error" => "Erro ao atualizar pedido", "status" => 500];
    }

    // Deletar pedido
    public function delete($id) {
        $this->pedido->id = $id;
        
        if(!$this->pedido->readOne()) {
            return ["error" => "Pedido não encontrado", "status" => 404];
        }

        if($this->pedido->delete()) {
            return ["message" => "Pedido deletado com sucesso"];
        }
        return ["error" => "Erro ao deletar pedido", "status" => 500];
    }

    // Buscar pedidos por cliente
    public function getByCliente($cliente_id) {
        if (!$this->validaCliente($cliente_id)) {
            return ["error" => "Cliente não encontrado", "status" => 404];
        }

        $stmt = $this->pedido->readByCliente($cliente_id);
        $pedidos = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($pedidos, $row);
        }

        return $pedidos;
    }

    // Validar se cliente existe
    private function validaCliente($cliente_id) {
        $cliente = new Cliente($this->db);
        $cliente->id = $cliente_id;
        return $cliente->readOne() ? true : false;
    }
} 