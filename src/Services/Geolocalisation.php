<?php

namespace App\Services;

use Error;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Geolocalisation
{
    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function getPosition(string $location)
    {
        $response = $this->client->request(
            'GET',
            'https://geocode.search.hereapi.com/v1/geocode',
            [
                "query" => [
                    'q' => "FRANCE" . $location,
                    'apiKey' => $_ENV['APP_HERE_API']
                ]
            ]
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new Error("Une erreur est survenue, veuillez réessayer.");
        } else {
            $position = $response->getContent();
            $position = $response->toArray();
            return $position['items'][0]["position"];
        }
    }
}
