<?php

namespace App\Services;

use App\Entity\GpsPositionInterface;

class DistanceCalculator
{
    public const EARTH_RADIUS = 3958.756;

    public function calculateDistance(GpsPositionInterface $searchLocation, GpsPositionInterface $offerLocation): float
    {
        $latitudeA = deg2rad($searchLocation->getLatitude());
        $longitudeA = deg2rad($searchLocation->getLongitude());
        $latitudeB = deg2rad($offerLocation->getLatitude());
        $longitudeB = deg2rad($offerLocation->getLongitude());

        $diffLong = $longitudeB - $longitudeA;
        $diffLati = $latitudeB - $latitudeA;

        $val = pow(sin($diffLati / 2), 2) + cos($latitudeA) * cos($latitudeB) * pow(sin($diffLong / 2), 2);

        $result = 2 * asin(sqrt($val));

        return ($result * self::EARTH_RADIUS) * 1.609;
    }
}
