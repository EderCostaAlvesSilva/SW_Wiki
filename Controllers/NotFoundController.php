<?php


class NotFoundController
{
    public function index()
    {
        http_response_code(404); 
        header('Content-Type: application/json');
        echo json_encode([
            'error' => 'Not Found',
            'message' => 'A rota solicitada não foi encontrada no servidor.'
        ]);
        exit;
    }
}