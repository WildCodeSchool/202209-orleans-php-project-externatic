<?php

namespace App\Entity;

use App\Entity\GpsPositionInterface;

class SearchOfferModule implements GpsPositionInterface
{
    private ?float $longitude = null;
    private ?float $latitude = null;
    private ?string $search = null;
    private ?string $location = null;
    private int $range = 5;

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
    public function getLatitude(): ?float
    {
        return $this->latitude;
    }
    public function getSearch(): ?string
    {
        return $this->search;
    }
    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }
    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }
    public function setSearch(?string $search): ?self
    {
        $this->search = $search;

        return $this;
    }
    public function getLocation(): ?string
    {
        return $this->location;
    }
    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }
    public function getRange(): int
    {
        return $this->range;
    }
    public function setRange(int $range): self
    {
        $this->range = $range;

        return $this;
    }
}
