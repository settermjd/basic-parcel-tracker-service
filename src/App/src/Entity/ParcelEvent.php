<?php
declare(strict_types=1);

namespace App\Entity;

class ParcelEvent
{
    private int $id;
    private string $carrierName;
    private string $type;
    private string $lastUpdated;
    private string $location;
    private int $parcelId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCarrierName(): string
    {
        return $this->carrierName;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getLastUpdated(): string
    {
        return $this->lastUpdated;
    }

    public function getLocation(): string
    {
        return $this->location;
    }

    public function getParcelId(): int
    {
        return $this->parcelId;
    }
}
