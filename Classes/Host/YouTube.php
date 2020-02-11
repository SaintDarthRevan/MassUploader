<?php


namespace MassUploader\Hosts;

class YouTube extends Host
    implements Intefaces\Auth, Intefaces\CliLaunch
{
    private $client;
    private $service;
    protected $object_type = 'Video';

    protected function auth()
    {
        $client = new \Google_Client();
        $client->setApplicationName('API code samples');
        $client->setScopes([
            'https://www.googleapis.com/auth/youtube.readonly',
        ]);
        $client->setAuthConfig('configs/hosts/YouTube/client_secret_246945352130-fa5vvqbjpabir2ll8o6okjufk65d30v3.apps.googleusercontent.com.json');
        $client->setAccessType('offline');

        $authUrl = $client->createAuthUrl();
        printf("Open this link in your browser:\n%s\n", $authUrl);
        print('Enter verification code: ');
        $authCode = trim(fgets(STDIN));

        $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

        $this->client->setAccessToken($accessToken);

        $this->service = new \Google_Service_YouTube($client);
    }

    public function checkChannelExists()
    {
        $queryParams = [
            'id' => $this->configs->channel_id
        ];

        $part = 'snippet,contentDetails,statistics';

        $response = $this->service->channels->listChannels($part, $queryParams);
        $response = json_decode($response, true);

        if (!empty($response['pageInfo']['totalResults'])) {
           return true;
        }

        return false;
    }

}