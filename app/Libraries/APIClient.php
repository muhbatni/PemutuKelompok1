<?php

namespace App\Libraries;

class APIClient
{
    protected $baseUrl = 'http://localhost:3000/api';

    protected function request($method, $endpoint, $data = null)
    {
        if (!extension_loaded('curl')) {
        throw new \RuntimeException('cURL extension is not loaded. Please enable it in php.ini');
    }

        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            return ['error' => $error];
        }

        return json_decode($response, true);
    }

    public function getAllStandar()
    {
        return $this->request('get', '/standar');
    }

    public function getStandar($id)
    {
        return $this->request('get', "/standar/{$id}");
    }

    public function createStandar($data)
    {
        return $this->request('post', '/standar', $data);
    }

    public function updateStandar($id, $data)
    {
        return $this->request('put', "/standar/{$id}", $data);
    }

    public function deleteStandar($id)
    {
        return $this->request('delete', "/standar/{$id}");
    }
}
