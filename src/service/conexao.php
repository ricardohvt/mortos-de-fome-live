<?php
 
class usePDO
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "teste2";
    private $instance;
 
    function getInstance()
    {
        if (empty($this->instance)) {
            $this->instance = $this->connection();
        }
 
        return $this->instance;
    }
 
    private function connection()
    {
        try {
            $conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}",$this->username,$this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage() . "<br>");
        }
    }
}

function instance2(){
    $servidor = "localhost";
    $usuario = "root";
    $senha = "";
    $banco = "teste2";
    $conexao = new mysqli($servidor, $usuario, $senha, $banco);
    
    if ($conexao->connect_error) {
        die("Falha na conexão: " . $conexao->connect_error);
    }
    
    
    $conexao->set_charset("utf8");
    return $conexao;
}
