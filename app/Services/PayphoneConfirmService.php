<?php

namespace App\Services;

use InvalidArgumentException;

class PayphoneConfirmService
{
    private $apiUrl = 'https://pay.payphonetodoesposible.com/api/button/V2/Confirm';
    private $token;

    public function __construct()
    {
        $this->token = getenv('PAYPHONE_API_TOKEN');
        if (!$this->token) {
            throw new InvalidArgumentException('API token is missing.');
        }
    }

    public function confirmTransaction($id, $clientTransactionId)
    {
        // Validar los parámetros
        if (empty($id) || empty($clientTransactionId)) {
            return ['success' => false, 'error' => 'Transaction ID and Client Transaction ID are required.'];
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode([
                'id' => $id,
                'clientTxId' => $clientTransactionId
            ]),
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token,
                'Content-Type: application/json'
            ],
        ]);

        $response = curl_exec($curl);
        $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return ['success' => false, 'error' => $err];
        }

        $result = json_decode($response, true);

        if ($httpStatusCode !== 200) {
            return ['success' => false, 'error' => 'API request failed with status code ' . $httpStatusCode, 'data' => $result];
        }

        if (!isset($result['transactionStatus'])) {
            return ['success' => false, 'error' => 'Invalid response from API', 'data' => $result];
        }

        return ['success' => $result['transactionStatus'] === 'Approved', 'data' => $result];
    }
}
