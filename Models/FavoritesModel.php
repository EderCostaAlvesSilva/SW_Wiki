<?php

class FavoritesModel extends Database
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

    public function listMyFavorites($userId)
    {
        $sql = "SELECT id, user, route, titulo FROM favorites WHERE user = :user";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user', $userId);
        $stmt->execute();

        $favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($favorites) {
            return [
                'success' => true,
                'message' => $favorites
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nenhum favorito encontrado.'
            ];
        }
    }

    public function getFavorite($data)
    {
        $sql = "SELECT id, user, route, titulo FROM favorites WHERE user = :user AND route = :route";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user', $data['user']);
        $stmt->bindParam(':route', $data['route']);
        $stmt->execute();

        $favorite = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($favorite) {
            return [
                'success' => true,
                'message' => $favorite
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Favorito não encontrado.'
            ];
        }
    }

    public function create($data)
    {
        $sql = "INSERT INTO favorites (user, route, titulo) VALUES (:user, :route, :titulo)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user', $data['user']);
        $stmt->bindParam(':route', $data['route']);
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
                'message' => 'Erro ao inserir favorito',
            ];
        }

    }

    public function delete($id)
    {
        $sql = "DELETE FROM favorites WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'message' => 'Favorito deletado com sucesso.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Favorito não encontrado.'
            ];
        }
    }
}