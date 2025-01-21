<?php

class UserController
{
    public function list()
    {
        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];

        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                '',
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }


        $UserModel = new UsersModel();
        $res = $UserModel->listUsers();

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                '',
                json_encode($res, JSON_UNESCAPED_UNICODE)
            );
 
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                '',
                json_encode($res, JSON_UNESCAPED_UNICODE)
            );
 
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }


    }
    public function create()
    {
        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];

        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {

            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );

            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }



        $missingFields = [];

        if (!isset($data['nome'])) {
            $missingFields[] = 'nome';
        }

        if (!isset($data['email'])) {
            $missingFields[] = 'email';
        }

        if (!isset($data['senha'])) {
            $missingFields[] = 'senha';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (strlen($data['nome']) < 3 || strlen($data['nome']) > 100) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'O campo nome deve ter entre 3 e 100 caracteres'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'O campo nome deve ter entre 3 e 100 caracteres'], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (strlen($data['senha']) < 3 || strlen($data['senha']) > 6) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $body = [
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => password_hash($data['senha'], PASSWORD_DEFAULT)
        ];

        $UserModel = new UsersModel();
        if ($UserModel->checkIfExists($body)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Nome ou email já estão cadastrados'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Nome ou email já estão cadastrados'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $res = $UserModel->create($body);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, 'id' => $res['id']], JSON_UNESCAPED_UNICODE)
            );
            echo json_encode(['success' => true, 'id' => $res['id']], JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => false, 'error' => 'Erro ao criar usuário'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Erro ao criar usuário'], JSON_UNESCAPED_UNICODE);
        }
    }
    
    public function auth()
    {
        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];
        $data = json_decode(file_get_contents('php://input'), true);
        
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );

            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $missingFields = [];

        if (!isset($data['email'])) {
            $missingFields[] = 'email';
        }

        if (!isset($data['senha'])) {
            $missingFields[] = 'senha';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (strlen($data['senha']) < 3 || strlen($data['senha']) > 6) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $body = [
            'email' => $data['email'],
            'senha' => $data['senha']
        ];

        $UserModel = new UsersModel();
        $res = $UserModel->auth($body);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode($res, JSON_UNESCAPED_UNICODE)
            );
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode($res, JSON_UNESCAPED_UNICODE)
            );
            http_response_code(404);
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
    }
    public function update($id)
    {

        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }


        $missingFields = [];

        if (!isset($data['id'])) {
            $missingFields[] = 'id';
        }

        if (!isset($data['nome'])) {
            $missingFields[] = 'nome';
        }

        if (!isset($data['email'])) {
            $missingFields[] = 'email';
        }

        if (!isset($data['senha'])) {
            $missingFields[] = 'senha';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (strlen($data['nome']) < 3 || strlen($data['nome']) > 100) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'O campo nome deve ter entre 3 e 100 caracteres'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'O campo nome deve ter entre 3 e 100 caracteres'], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'O campo email deve ser um email válido'], JSON_UNESCAPED_UNICODE);
            die;
        }

        if (strlen($data['senha']) < 3 || strlen($data['senha']) > 6) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'A senha deve ter entre 3 e 6 caracteres'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $body = [
            'id' => $data['id'],
            'nome' => $data['nome'],
            'email' => $data['email'],
            'senha' => password_hash($data['senha'], PASSWORD_DEFAULT), 
        ];

        $UserModel = new UsersModel();
        $res = $UserModel->update($body);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, 'message' => $res['message']], JSON_UNESCAPED_UNICODE)
            );
            echo json_encode(['success' => true, 'message' => $res['message']], JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => false, 'error' => $res['message']], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => $res['message']], JSON_UNESCAPED_UNICODE);
        }
    }

    public function delete()
    {

        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];
        $data = json_decode(file_get_contents('php://input'), true);

        if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $missingFields = [];

        if (!isset($data['id'])) {
            $missingFields[] = 'id';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        $UserModel = new UsersModel();
        $res = $UserModel->delete($data['id']);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, 'message' => $res['message']], JSON_UNESCAPED_UNICODE)
            );
            echo json_encode(['success' => true, 'message' => $res['message']], JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => false, 'error' => $res['message']], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $res['message']], JSON_UNESCAPED_UNICODE);
        }
    }

}
