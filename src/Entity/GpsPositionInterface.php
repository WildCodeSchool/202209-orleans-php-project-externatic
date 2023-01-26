<?php

namespace App\Entity;

interface GpsPositionInterface
{
    public function getLatitude(): ?float;
    public function getLongitude(): ?float;
    public function setLatitude(float $latitude): ?self;
    public function setLongitude(float $longitude): ?self;
}
