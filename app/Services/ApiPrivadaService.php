<?php

namespace App\Services;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\HTTP\Exceptions\HTTPException;
use Config\Services;

class ApiPrivadaService
{
    public function getDataUser($id)
    {
        try {
            $client = Services::curlrequest();

            if (strlen($id) == 13) {
                $url = "https://apipersonas.softecsa.com/api/ruc/" . $id;
            } else {
                $url = "https://apipersonas.softecsa.com/api/ci/" . $id;
            }

            $token = getenv('API_PERSONAS');

            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                return json_decode($response->getBody(), true);
            } else {
                log_message('warning', 'Solicitud fallida', ['id' => $id, 'status' => $response->getStatusCode()]);
                return null;
            }
        } catch (\Exception $e) {
            log_message('error', 'Excepción en solicitud', ['id' => $id, 'error' => $e->getMessage()]);
            return null;
        }
    }
}
