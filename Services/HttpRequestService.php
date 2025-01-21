<?php

class HttpRequestService {
    private $url;
    private $data;
    private $method;
    private $headers;

    public function __construct($url, $data = [], $method = 'GET', $headers = ['Content-Type: application/json']) {
        $this->url = $url;
        $this->data = $data;
        $this->method = strtoupper($method); 
        $this->headers = $headers;
    }

    public function request() {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        
        if ($this->method !== 'GET') {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);

            if (!empty($this->data)) {
                $payload = is_array($this->data) ? json_encode($this->data) : $this->data;
                curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

               
                if (!array_filter($this->headers, fn($header) => stripos($header, 'Content-Type') !== false)) {
                    $this->headers[] = 'Content-Type: application/json';
                }
            }
        }

        if (!empty($this->headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
}
