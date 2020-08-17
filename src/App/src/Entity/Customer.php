<?php
declare(strict_types=1);

namespace App\Entity;

class Customer
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $emailAddress;
    private string $phoneNumber;
    private int $addressId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getAddressId(): int
    {
        return $this->addressId;
    }
}