<?php

class APIClient
{
    private const API_URL = 'https://hustlers.ly/api/api';
    private const API_KEY = '95e7b2cb83ef7f2c638eb88b839a49c0';
    private const USER_AGENT = 'Hustlers/1.0';

    public function sendRequest(array $data): ?string
    {
        $ch = curl_init(self::API_URL);

        if ($ch === false) {
            throw new RuntimeException('Failed to initialize cURL.');
        }

        $data['key'] = self::API_KEY;
        $postData = http_build_query($data);

        curl_setopt_array($ch, [
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT      => self::USER_AGENT,
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            $error = curl_error($ch);
            curl_close($ch);
            throw new RuntimeException("cURL request failed: $error");
        }

        curl_close($ch);
        return $response;
    }
}

try {
    $apiClient = new APIClient();
    $data = [
        'From'    => 'Name',
        'phone'   => '44xxxxxxxxxx',
        'message' => 'Your message here.',
    ];
    $response = $apiClient->sendRequest($data);
    echo $response;
} catch (RuntimeException $e) {
    error_log($e->getMessage());
}

?>
