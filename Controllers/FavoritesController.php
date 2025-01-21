<?php

class FavoritesController
{
    public function listMyfavorites($user)
    {
        $LogModel = new LogModel();
        $url = $_SERVER['REQUEST_URI'];

        $data = (int) $user[0];

        if ($_SERVER['REQUEST_METHOD'] != 'GET') {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data),
                json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota'], JSON_UNESCAPED_UNICODE);
            die;
        }

        $missingFields = [];

        if (!isset($data)) {
            $missingFields[] = 'user';
        }

        if (!empty($missingFields)) {

            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );

            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        $FavoritesModel = new FavoritesModel();
        $res = $FavoritesModel->listMyFavorites($data);

        if ($res['success']) {

            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, $res['message']], JSON_UNESCAPED_UNICODE)
            );

            echo json_encode(['success' => true, 'results' => $res['message']], JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => false, 'error' => 'favorito não localizado'], JSON_UNESCAPED_UNICODE)
            );

            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Favoritos não encontrado'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getFavorite()
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

        if (!isset($data['user'])) {
            $missingFields[] = 'user';
        }

        if (!isset($data['route'])) {
            $missingFields[] = 'route';
        }

        if (isset($data['user']) && !is_numeric($data['user'])) {
            $missingFields[] = 'user deve ser um número';
        }

        if (isset($data['route']) && !is_string($data['route'])) {
            $missingFields[] = 'route deve ser uma string';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        $body = [
            'user' => $data['user'],
            'route' => $data['route']
        ];

        $FavoritesModel = new FavoritesModel();
        $res = $FavoritesModel->getFavorite($body);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, 'results' => $res['message']], JSON_UNESCAPED_UNICODE)
            );
            echo json_encode(['success' => true, 'results' => $res['message']], JSON_UNESCAPED_UNICODE);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => false, 'error' => 'favorito não localizado'], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'favorito não localizado'], JSON_UNESCAPED_UNICODE);
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

        if (!isset($data['user'])) {
            $missingFields[] = 'user';
        }

        if (!isset($data['route'])) {
            $missingFields[] = 'route';
        }

        if (!isset($data['titulo'])) {
            $missingFields[] = 'titulo';
        }

        if (isset($data['user']) && !is_numeric($data['user'])) {
            $missingFields[] = 'user deve ser um número';
        }

        if (isset($data['route']) && !is_string($data['route'])) {
            $missingFields[] = 'route deve ser uma string';
        }

        if (isset($data['titulo']) && !is_string($data['titulo'])) {
            $missingFields[] = 'titulo deve ser uma string';
        }

        if (!empty($missingFields)) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE)
            );
            http_response_code(400);
            echo json_encode(['error' => 'Campos obrigatórios ausentes ou inválidos: ' . implode(', ', $missingFields)], JSON_UNESCAPED_UNICODE);
            die;
        }

        $body = [
            'user' => $data['user'],
            'route' => $data['route'],
            'titulo' => $data['titulo']
        ];

        $FavoritesModel = new FavoritesModel();
        $res = $FavoritesModel->create($body);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data, JSON_UNESCAPED_UNICODE),
                json_encode(['success' => true, $res['id']], JSON_UNESCAPED_UNICODE)
            );
            echo json_encode(['success' => true, 'id' => $res['id']], JSON_UNESCAPED_UNICODE);
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

        $FavoritesModel = new FavoritesModel();
        $res = $FavoritesModel->delete($data['id']);

        if ($res['success']) {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data),
                json_encode(['success' => true, 'message' => $res['message']])
            );
            echo json_encode(['success' => true, 'message' => $res['message']]);
        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                json_encode($data),
                json_encode(['success' => false, 'error' => $res['message']])
            );
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => $res['message']]);
        }
    }
}