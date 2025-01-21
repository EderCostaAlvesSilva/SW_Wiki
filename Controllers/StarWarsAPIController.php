<?php
class StarWarsAPIController
{
    // Método genérico para validar o método da requisição
    private function checkRequestMethod()
    {
        if (
            $_SERVER['REQUEST_METHOD'] != 'GET') {
            http_response_code(405);
            echo json_encode(['error' => 'Método não permitido para essa rota.'], JSON_UNESCAPED_UNICODE)
            ;
            return true;
        }
        return false;
    }

    // Método genérico para realizar as requisições
    private function makeRequest($endpoint)
    {
        try {
            $request = new HttpRequestService($endpoint);
            $response = $request->request();

            if ($response === false) {
                echo json_encode(['error' => 'Falha ao realizar a requisição.'], JSON_UNESCAPED_UNICODE);
            }

            return $response;

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
            die;
        }
    }

    // Método para listar qualquer recurso
    private function listResource($resource)
    {
        if ($this->checkRequestMethod())
            return;

        $url = $_SERVER['REQUEST_URI'];

        $response = $this->makeRequest("https://www.swapi.tech/api/$resource");
        $data = json_decode($response, true);

        $LogModel = new LogModel();

        if (isset($data['message']) && $data['message'] == 'ok') {

            $LogModel->createLog(
                'GET',
                $url,
                '',
                json_encode($data['results'],JSON_UNESCAPED_UNICODE)
            );

            echo json_encode($data['results'],JSON_UNESCAPED_UNICODE);
            die;

        } else {

            $LogModel->createLog('GET', $url, '', ["error" => "conteúdo não localizado"]);

            echo json_encode(["error" => "conteúdo não localizado"],JSON_UNESCAPED_UNICODE);
            die;

        }
    }

    // Método para obter um recurso específico pelo ID
    private function getResourceById($resource, $id)
    {
        if ($this->checkRequestMethod())
            return;

        $url = $_SERVER['REQUEST_URI'];

        $response = $this->makeRequest("https://www.swapi.tech/api/$resource/$id");
        $data = json_decode($response, true);

        $LogModel = new LogModel();

        if (isset($data['message']) && $data['message'] == 'ok') {

            if ($resource == 'films') {
                $film = $data['result'];

                $releaseDate = new DateTime($film['properties']['release_date']);
                $currentDate = new DateTime();
                $interval = $releaseDate->diff($currentDate);

                $data['result']['properties']['release_date'] = $releaseDate->format('d/m/Y');
                $data['result']['img'] = $film['_id'];
                $data['result']['age'] = [
                    'years' => $interval->y,
                    'months' => $interval->m,
                    'days' => $interval->d
                ]; 


            }

            $LogModel->createLog(
                'GET',
                $url,
                '',
                json_encode($data['result'], JSON_UNESCAPED_UNICODE)
            );

            echo json_encode($data['result'], JSON_UNESCAPED_UNICODE);
            die;

        } else {

            $res = json_encode(["error" => "conteúdo não localizado"], JSON_UNESCAPED_UNICODE);

            $LogModel->createLog('GET', $url, '', $res);

            echo $res;
            die;

        }


    }

    // Métodos para os recursos específicos
    public function listFilms()
    {
        if ($this->checkRequestMethod())
            return;

        $response = $this->makeRequest("https://www.swapi.tech/api/films");
        $data = json_decode($response, true);

        $url = $_SERVER['REQUEST_URI'];

        $LogModel = new LogModel();

        if (isset($data['result']) && is_array($data['result'])) {

            usort($data['result'], function ($a, $b) {
                $dateA = new DateTime($a['properties']['release_date']);
                $dateB = new DateTime($b['properties']['release_date']);
                return $dateA <=> $dateB;
            });

            $filmsData = array_map(function ($film) {

                $releaseDate = new DateTime($film['properties']['release_date']);
                $currentDate = new DateTime();
                $interval = $releaseDate->diff($currentDate);

                return [
                    'description' => $film['description'],
                    'title' => $film['properties']['title'],
                    'episode_id' => $film['properties']['episode_id'],
                    'release_date' => $releaseDate->format('d/m/Y'),
                    'id' => $film['uid'],
                    'img' => $film['_id'],
                    'age' => [
                        'years' => $interval->y,
                        'months' => $interval->m,
                        'days' => $interval->d
                    ]

                ];
            }, $data['result']);

            $LogModel->createLog(
                'GET',
                $url,
                '',
                json_encode($filmsData, JSON_UNESCAPED_UNICODE)
            );

            echo json_encode($filmsData, JSON_UNESCAPED_UNICODE);
        } else {

            $LogModel->createLog('GET', $url, '', ["error" => "conteúdo não localizado"]);

            http_response_code(400);
            echo json_encode(['error' => 'conteúdo não localizado'], JSON_UNESCAPED_UNICODE);
        }
        die;
    }

    public function calculateAge($releaseDate)
    {
        $releaseDateObj = new DateTime($releaseDate);
        $currentDate = new DateTime();
        $interval = $releaseDateObj->diff($currentDate);

        return [
            'years' => $interval->y,
            'months' => $interval->m,
            'days' => $interval->d
        ];
    }

    public function getFilms($params)
    {
        $id = $params[0];
        $this->getResourceById('films', $id);
    }

    public function listPlanets()
    {
        $this->listResource('planets?page=2&limit=60');
    }

    public function getPlanets($params)
    {
        $id = $params[0];
        $this->getResourceById('planets', $id);
    }

    public function listPeople()
    {
        $this->listResource('people?page=2&limit=100');
    }

    public function getPeople($params)
    {
        $id = $params[0];
        $this->getResourceById('people', $id);
    }

    public function listSpecies()
    {
        $this->listResource('species?page=2&limit=37');
    }

    public function getSpecies($params)
    {
        $id = $params[0];
        $this->getResourceById('species', $id);
    }

    public function listStarships()
    {
        $this->listResource('starships?page=2&limit=36');
    }

    public function getStarships($params)
    {
        $id = $params[0];
        $this->getResourceById('starships', $id);
    }

    public function listVehicles()
    {
        $this->listResource('vehicles?page=2&limit=39');
    }

    public function getVehicles($params)
    {
        $id = $params[0];
        $this->getResourceById('vehicles', $id);
    }
}
