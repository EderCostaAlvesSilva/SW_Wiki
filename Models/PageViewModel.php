<?php

class PageViewModel extends Database
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

    public function list()
    {
        $sql = 'SELECT rota, 
                    COUNT(*) AS quantidade, 
                    MAX(titulo) AS titulo, 
                    MAX(datavisualizada) AS data_mais_recente
                FROM historypage
                GROUP BY rota
                ORDER BY quantidade DESC';

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute();

        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($list) {
            return [
                'success' => true,
                'message' => $list
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nenhum histórico de página encontrado.'
            ];
        }
    }



    public function create($data)
    {
        $sql = 'INSERT INTO historypage (rota, titulo, datavisualizada) VALUES 
        (:rota , :titulo, now())';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':rota', $data['rota']);
        $stmt->bindParam(':titulo', $data['titulo']);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'id' => $this->pdo->lastInsertId(),
            ];
        } else {
            return [
                'success' => false,
                'message' => 'erro ao registrar histórico'
            ];
        }
    }
}