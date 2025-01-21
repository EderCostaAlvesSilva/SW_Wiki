<?php

class CommentsModel extends Database
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
        $sql = 'SELECT comments.id, comments.route, users.nome AS user_name, comments.comentario, comments.titulo,comments.datahora FROM  comments INNER JOIN  users  ON  users.id = comments.user ORDER BY 
    comments.datahora DESC';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($comments) {
            return [
                'success' => true,
                'message' => $comments
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nenhum comentario encontrado.'
            ];
        }
    }

    public function create($data)
    {
        $sql = 'INSERT INTO sw_movies.comments (  route, user, comentario, titulo, datahora) VALUES (:route , :user , :comentario , :titulo,now())';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':user', $data['user']);
        $stmt->bindParam(':route', $data['route']);
        $stmt->bindParam(':comentario', $data['comentario']);
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
                'message' => 'Erro ao inserir usuário',
            ];
        }
    }

    public function getComments($route)
    {
        $sql = 'SELECT comments.id, comments.route, users.nome AS user_name, comments.comentario, comments.titulo, comments.datahora FROM  comments 
INNER JOIN  users  ON  users.id = comments.user 
where comments.route = :route
ORDER BY comments.datahora DESC';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':route', $route);
        $stmt->execute();

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($comments) {
            return [
                'success' => true,
                'message' => $comments
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Comentario não encontrado para essa rota.'
            ];
        }
    }

    public function delete($data)
    {
        $sql = ' DELETE FROM  comments WHERE route = :route and user = :user';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':route', $data['route']);
        $stmt->bindParam(':user', $data['user']);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'message' => 'Comentario deletado com sucesso.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Comentario não encontrado.'
            ];
        }
    }
}