<?php
namespace App\Controllers\Administrativo\Trabajadores;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PersonaController extends BaseController
{
    public function consultarDNI($dni = null)
    {
        if (!$dni) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                  ->setJSON(['error' => 'Debe enviar un DNI']);
        }

        $token = "sk_10086.wltuhOuCM6vA8smu6nhgTV26pYROGsoe"; 

        $client = \Config\Services::curlrequest();
        try {
            $response = $client->request('GET', "https://api.decolecta.com/v1/reniec/dni?numero={$dni}", [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => "Bearer {$token}"
                ],
            ]);

            $body = $response->getBody();
            return $this->response->setJSON(json_decode($body, true));

        } catch (\Exception $e) {
            return $this->response->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                                 ->setJSON(['error' => $e->getMessage()]);
        }
    }
}


