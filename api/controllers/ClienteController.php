<?php
class ClienteController {
    private $db;
    private $cliente;

    public function __construct($db) {
        $this->db = $db;
        $this->cliente = new Cliente($db);
    }

    public function create($data) {
        if(!isset($data['nome']) || !isset($data['email'])) {
            return ["error" => "Dados incompletos", "status" => 400];
        }

        $this->cliente->nome = $data['nome'];
        $this->cliente->email = $data['email'];
        $this->cliente->telefone = $data['telefone'] ?? '';

        if($this->cliente->create()) {
            return ["message" => "Cliente criado com sucesso", "status" => 201];
        }
        return ["error" => "Erro ao criar cliente", "status" => 500];
    }

    public function getAll() {
        $stmt = $this->cliente->read();
        $clientes = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($clientes, $row);
        }

        return $clientes;
    }

    public function getById($id) {
        $this->cliente->id = $id;
        $cliente = $this->cliente->readOne();

        if($cliente) {
            return $cliente;
        }
        return ["error" => "Cliente não encontrado", "status" => 404];
    }

    public function update($id, $data) {
        $this->cliente->id = $id;
        
        if(!$this->cliente->readOne()) {
            return ["error" => "Cliente não encontrado", "status" => 404];
        }

        $this->cliente->nome = $data['nome'] ?? $this->cliente->nome;
        $this->cliente->email = $data['email'] ?? $this->cliente->email;
        $this->cliente->telefone = $data['telefone'] ?? $this->cliente->telefone;

        if($this->cliente->update()) {
            return ["message" => "Cliente atualizado com sucesso"];
        }
        return ["error" => "Erro ao atualizar cliente", "status" => 500];
    }

    public function delete($id) {
        $this->cliente->id = $id;
        
        if(!$this->cliente->readOne()) {
            return ["error" => "Cliente não encontrado", "status" => 404];
        }

        if($this->cliente->delete()) {
            return ["message" => "Cliente deletado com sucesso"];
        }
        return ["error" => "Erro ao deletar cliente", "status" => 500];
    }
} 