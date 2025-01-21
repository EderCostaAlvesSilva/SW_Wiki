<?php

class LogModel extends Database
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = $this->getConnection();
            if ($this->pdo === null) {
                throw new Exception("Falha ao estabelecer conexão com o banco de dados.");
            }
        } catch (Exception $e) {

            error_log($e->getMessage());
            die("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }
    }

    public function createLog($method, $url, $body = null, $response)
    {
        $sql = "INSERT INTO logs (timestamp, method, url, body, response) 
                VALUES (NOW(), :method, :url, :body, :response)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':method' => $method,
            ':url' => $url,
            ':body' => $body,
            ':response' => $response
        ]);
    }

    public function getLog()
    {
        $sql = "SELECT * FROM api_logs";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
