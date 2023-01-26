<?php

namespace App\Services;

use App\Entity\SearchOfferModule;
use App\Repository\OfferRepository;

class OfferFounder
{
    public function __construct(
        private Geolocalisation $geolocalisation,
        private OfferRepository $offerRepository,
        private DistanceCalculator $distanceCalculator
    ) {
    }
    public function foundByLocation(SearchOfferModule $searchOfferModule): array
    {
        if ($searchOfferModule->getLocation() !== null) {
            $position = $this->geolocalisation->find($searchOfferModule->getLocation());
        }
        if (!empty($position)) {
            $searchOfferModule->setLatitude($position['lat'])->setLongitude($position['lng']);
        }
        $offers = $this->offerRepository->findByKeyWord($searchOfferModule);

        if (!empty($position)) {
            $offersInRange = [];
            foreach ($offers as $offer) {
                if (
                    $this->distanceCalculator->calculateDistance(
                        $searchOfferModule,
                        $offer
                    ) <= $searchOfferModule->getRange()
                ) {
                    $offersInRange[] = $offer;
                }
            }
            $offers = $offersInRange;
        }
        return $offers;
    }
}
