<?php

namespace App\Services;

use App\Entity\Offer;

class OfferToJson
{
    public function get(array $offers): string
    {
        $json = [];
        foreach ($offers as $offer) {
            $json[] = [
                "id" => $offer->getId(),
                "title" => $offer->getTitle(),
                "latitude" => $offer->getLatitude(),
                "longitude" => $offer->getLongitude(),
            ];
        }
        return json_encode($json);
    }
}
