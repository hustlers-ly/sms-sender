import requests
import json

class APIClient:
    API_URL = 'https://hustlers.ly/api/api'
    API_KEY = '95e7b2cb83ef7f2c638eb88b839a49c0'
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
