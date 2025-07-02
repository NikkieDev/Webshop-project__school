<?php

class CreateOrderProps
{
    private string $userUuid = "";
    private string $streetWithNumber = "";
    private string $zipCode = "";
    private string $location = "";
    private float $price = 0.00;
    

    public function __construct(
        string $userUuid,
        string $streetWithNumber,
        string $zipCode,
        string $location,
        float $price
    )
    {
        $this->userUuid = $userUuid;
        $this->streetWithNumber = $streetWithNumber;
        $this->zipCode = $zipCode;
        $this->location = $location;
        $this->price = $price;
    }

    public function getUserUuid()
    {
        return $this->userUuid;
    }

    public function setUserUuid(string $userUuid)
    {
        $this->userUuid = $userUuid;
    }

    public function getStreetWithNumber()
    {
        return $this->streetWithNumber;
    }

    public function setStreetWithNumber(string $streetWithNumber)
    {
        $this->streetWithNumber = $streetWithNumber;
    }

    public function getZipCode()
    {
        return $this->zipCode;
    }

    public function setZipCode(string $zipCode)
    {
        $this->zipCode = $zipCode;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getVat(): float
    {
        return $this->price * 0.21;
    }
}