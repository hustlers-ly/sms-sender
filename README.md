# Hustlers API

Hustlers API allows you to send SMS messages through a simple POST request.

![Hustlers API Banner](https://i.ibb.co/4T6L4ym/fav.png)

## API Endpoint

**URL:** `https://hustlers.ly/api/api`

## API Key

**Key:** `95e7b2cb83ef3f2c438eb34b839a49c0`

You can obtain your API key by signing up at [hustlers.ly/signup](https://hustlers.ly/signup).

## Required Headers

- **User-Agent:** Must contain the string `Hustlers/1.0`

## HTTP Method

**POST**

## Request Parameters

| Parameter | Description               | Required | Type   |
|-----------|---------------------------|----------|--------|
| `From`    | Identifier for the sender | Yes      | String |
| `phone`   | Recipient's phone number  | Yes      | String |
| `message` | Content of the SMS message | Yes      | String |
| `key`     | API authorization key     | Yes      | String |

## Response Format

Responses are returned in JSON format.

### Success Response
```json
{
    "success": true,
    "message": "SMS sent successfully"
}
```

### Error Responses
```json
{
    "success": false,
    "message": "error message"
}
```

Possible error messages include:
- `Access denied.`
- `Please supply an API key.`
- `Please supply a Name.`
- `Please supply a Phone number.`
- `Please supply a Message.`
- `Invalid phone number.`
- `Invalid API key.`
- `No enough credit.`

## Example Code

### PHP Example
```php
<?php

class APIClient
{
    private const API_URL = 'https://hustlers.ly/api/api';
    private const API_KEY = '95e7b2cb83ef3f2c438eb34b839a49c0';
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
```

### Python Example
```python
import requests
import json

class APIClient:
    API_URL = 'https://hustlers.ly/api/api'
    API_KEY = '95e7b2cb83ef3f2c438eb34b839a49c0'
    USER_AGENT = 'Hustlers/1.0'

    def __init__(self, api_url=API_URL, api_key=API_KEY, user_agent=USER_AGENT):
        self.api_url = api_url
        self.api_key = api_key
        self.user_agent = user_agent

    def send_request(self, data):
        data['key'] = self.api_key
        headers = {
            'User-Agent': self.user_agent,
            'Content-Type': 'application/x-www-form-urlencoded'
        }
        try:
            response = requests.post(
                self.api_url,
                data=data,
                headers=headers
            )
            response.raise_for_status()
            return response.text
        except requests.RequestException as e:
            raise RuntimeError(f'Failed to send request: {e}')

def main():
    api_client = APIClient()
    data = {
        'From': 'Name',
        'phone': '44xxxxxxxxxx',
        'message': 'Your message here.'
    }
    try:
        response = api_client.send_request(data)
        print(response)
    except RuntimeError as e:
        print(f'Error: {e}')

if __name__ == '__main__':
    main()
```

