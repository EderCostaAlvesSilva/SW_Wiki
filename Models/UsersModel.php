<?php

class UsersModel extends Database
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

    public function listUsers()
    {
        $sql = 'SELECT id, nome, email, senha, nivel, created_at, updated_at FROM users';

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($users) {
            return [
                'success' => true,
                'message' => $users
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nenhum usuario encontrado.'
            ];
        }
    }

    public function create($data)
    {
        $sql = 'INSERT INTO users (nome, email, senha, created_at, updated_at)
                VALUES (:nome, :email, :senha, NOW(), NOW())';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':senha', $data['senha']);

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

    public function checkIfExists($data)
    {
        $sql = "SELECT id FROM users WHERE nome = :nome OR email = :email";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return false;
    }

    public function auth($data)
    {
        $sql = 'SELECT id, nome, email, senha, nivel FROM users WHERE email = :email';

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':email', $data['email']);

        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($data['senha'], $user['senha'])) {
            return [
                'success' => true,
                'result' => $user,
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Usuário não localizado',
            ];
        }
    }

    public function update($data)
    {
        $sql = "UPDATE users SET nome = :nome, email = :email, senha = :senha, updated_at = NOW() WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $data['id']);
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':senha', $data['senha']);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'message' => 'Usuário atualizado com sucesso'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Nenhuma alteração realizada ou usuário não encontrado'
            ];
        }
    }

    public function delete($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return [
                'success' => true,
                'message' => 'Usuário excluído com sucesso'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'Usuário não encontrado'
            ];
        }
    }
}
