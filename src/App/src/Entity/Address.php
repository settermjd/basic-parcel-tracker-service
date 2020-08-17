<?php
declare(strict_types=1);

namespace App\Entity;

class Address
{
    private int $id;
    private string $streetNumber;
    private string $streetName;
    private string $city;
    private string $state;
    private string $postCode;
    private string $country;

    public function getId(): int
    {
        return $this->id;
    }

    public function getStreetNumber(): string
    {
        return $this->streetNumber;
    }

    public function getStreetName(): string
    {
        return $this->streetName;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
}
