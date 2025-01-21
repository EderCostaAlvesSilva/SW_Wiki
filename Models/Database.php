<?php

class Database
{
    public function getConnection()
    {

        try{
            $pdo = new PDO("mysql:host=mysql;port=3306;dbname=sw_movies", "user.app", "vGbeAuu465Xd");
  
            return $pdo;
        }catch (PDOException $err) {
            header('Content-Type: application/json');
            http_response_code(503);
            echo json_encode([
                'success' => false,
                'error' => 'Banco de Dados Offline!',
                'details' => $err->getMessage()
            ], JSON_UNESCAPED_UNICODE);
            exit;
        }
    }
}