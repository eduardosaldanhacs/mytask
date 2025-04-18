<?php

require_once("models/Tarefa.php");
require_once("db.php");

class TarefaDAO implements TarefaDaoInterface {
    private $conn;
    private $url;
    private $message;
    //Criar conexão 
    public function __construct(PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
    }
    //Método para preencher um objeto tarefa
    public function preencherTarefa($data) {
        
        $tarefa = new Tarefa;

        $tarefa->id = $data['id'];
        $tarefa->id_status = $data['id_status'];
        $tarefa->tarefa = $data['tarefa'];

        return $tarefa;
        
    }
    //Método para criar um objeto tarefa
    public function criar(Tarefa $tarefa) {
        $data_cadastrada = date('Y-m-d H:i:s');
        $ativo = 'S';
        $stmt = $this->conn->prepare("INSERT INTO tarefas(tarefa, id_status, data_cadastro, ativo) VALUES (:tarefa, :id_status, :data_cadastrada, :ativo)");

            
            $stmt->bindParam(":tarefa", $tarefa->tarefa);
            $stmt->bindParam(":id_status", $tarefa->id_status);
            $stmt->bindParam(":data_cadastrada", $data_cadastrada);
            $stmt->bindParam(":ativo", $ativo);

            $stmt->execute();
        }

    //Método para atualizar um objeto tarefa
    public function atualizar($tarefa, $id_status, $id)
    {
        $stmt = $this->conn->prepare("UPDATE tarefas SET id_status = :id_status, tarefa = :tarefa WHERE id = $id");
        $stmt->bindParam(":tarefa", $tarefa);
        $stmt->bindParam(":id_status", $id_status);

        $stmt->execute();   
    }
    //Método que recupera só as tarefas nao concluidas, serve pra listar as tarefas pendentes
    public function recuperarTarefaNaoConcluida() {
        $tarefas = [];

        $stmt = $this->conn->prepare("SELECT * FROM tarefas WHERE id_status = 1 AND ativo = 'S'");

        $stmt->execute();


        $tarefas = $stmt->fetchAll();
        return $tarefas;
        
    }    
    //Método para remover uma tarefa
    public function removerTarefa($id) {
        $status = "E";
        $stmt = $this->conn->prepare("UPDATE tarefas SET ativo = :status WHERE id = $id");
        $stmt->bindParam(":status", $status);

        $stmt->execute();
    }
    //Método para concluir uma tarefa
    public function concluirTarefa($id) {
        $stmt = $this->conn->prepare("UPDATE tarefas SET id_status = 2 WHERE id = $id");

        $stmt->execute();
    }
    //Método que recupera todas as tarefa, serve pra listar todas as tarefas
    public function recuperarTodasTarefa() {
        $tarefas = [];

        $stmt = $this->conn->prepare("SELECT * FROM tarefas WHERE id_status = 1 OR 2 AND ativo = 'S'");
        $stmt->execute();


        $tarefas = $stmt->fetchAll();
        return $tarefas;
        
    }
    //Método para encontrar o id de uma tarefa
    public function recuperarTarefaId($id)
    {
        $stmt = $this->conn->prepare("SELECT * from tarefas WHERE id = $id");
        $stmt->execute();
        $tarefa = $stmt->fetch();
        return $tarefa;
    }
}
