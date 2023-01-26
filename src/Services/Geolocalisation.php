<?php

namespace App\Services;

use Error;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Geolocalisation
{
    private HttpClientInterface $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function find(string $location, string $postCode = ""): array
    {
        $response = $this->client->request(
            'GET',
            'https://api-adresse.data.gouv.fr/search/',
            [
                "query" => [
                    "q" => $location,
                    "postcode" => $postCode
                ]
            ]
        );

        $statusCode = $response->getStatusCode();
        if ($statusCode === 500) {
            throw new Error("Une erreur est survenue, veuillez réessayer.", 500);
        } elseif ($statusCode === 400) {
            return [];
        } else {
            $position = $response->toArray();
            if (empty($position["features"])) {
                $positionFormat = [];
            } else {
                $position = $position["features"][0]["geometry"]["coordinates"];

                $positionFormat = [
                    "lat" => $position[1],
                    "lng" => $position[0]
                ];
            }
            return $positionFormat;
        }
    }
}
