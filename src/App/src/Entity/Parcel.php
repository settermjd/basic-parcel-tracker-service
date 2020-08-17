<?php
declare(strict_types=1);

namespace App\Entity;

class Parcel
{
    private int $id;
    private string $heightValue;
    private string $heightUnit;
    private string $weightValue;
    private string $weightUnit;
    private string $valueValue;
    private string $valueUnit;
    private string $name;
    private string $description;

    public function getId(): int
    {
        return $this->id;
    }

    public function getHeightValue(): string
    {
        return $this->heightValue;
    }

    public function getHeightUnit(): string
    {
        return $this->heightUnit;
    }

    public function getWeightValue(): string
    {
        return $this->weightValue;
    }

    public function getWeightUnit(): string
    {
        return $this->weightUnit;
    }

    public function getValueValue(): string
    {
        return $this->valueValue;
    }

    public function getValueUnit(): string
    {
        return $this->valueUnit;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}