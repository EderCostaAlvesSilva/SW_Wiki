<?php

class PageViewController
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

        $PageViewModel = new PageViewModel();
        
        echo json_encode($PageViewModel->list());die;
        if ($res['success']) {

            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                '',
                json_encode(['success' => true, $res['message']], JSON_UNESCAPED_UNICODE)
            );

            echo json_encode(['success' => true, 'results' => $res['message']], JSON_UNESCAPED_UNICODE);

        } else {
            $LogModel->createLog(
                $_SERVER['REQUEST_METHOD'],
                $url,
                '',
                json_encode(['success' => false, 'error' => 'Paginas não localizada'], JSON_UNESCAPED_UNICODE)
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

        if (!isset($data['rota'])) {
            $missingFields[] = 'rota';
        }

        if (!isset($data['titulo'])) {
            $missingFields[] = 'titulo';
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
            'rota' => $data['rota'],
            'titulo' => $data['titulo']
        ];

        $PageViewModel = new PageViewModel();
        $res = $PageViewModel->create($body);

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
}