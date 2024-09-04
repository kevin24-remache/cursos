<?php

namespace App\Services;

use CodeIgniter\HTTP\Exceptions\HTTPException;
use CodeIgniter\HTTP\ResponseInterface;

class UserService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        // Inicializar el cliente HTTP y el token
        $this->client = \Config\Services::curlrequest();
        $this->token = getenv('USER_API_TOKEN');
    }
    public function getUserData($ci)
    {
        try {
            // Realizar la petición HTTP GET
            $response = $this->client->get("https://users.xyphire.com/api/data/$ci?token=$this->token");

            // Verificar si la respuesta fue exitosa
            if ($response->getStatusCode() === 200) {
                $responseData = json_decode($response->getBody(), true);

                // Verifica si hay un error en la respuesta
                if ($responseData['error'] === 'false') {
                    return $responseData['data'];  // Retorna solo la parte de datos
                } else {
                    throw new \Exception('Error en la respuesta de la API: ' . $responseData['status']);
                }
            } else {
                throw new \Exception('Error al obtener los datos del usuario. Código: ' . $response->getStatusCode());
            }
        } catch (HTTPException $e) {
            throw new \Exception('Error al comunicarse con la API externa: ' . $e->getMessage());
        }
    }
}
