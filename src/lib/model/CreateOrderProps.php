<?php

class CreateOrderProps
{
    private string $userUuid = "";
    private string $streetWithNumber = "";
    private string $zipCode = "";
    private string $location = "";

    public function __construct(
        string $userUuid,
        string $streetWithNumber,
        string $zipCode,
        string $location
    )
    {
        $this->userUuid = $userUuid;
        $this->streetWithNumber = $streetWithNumber;
        $this->zipCode = $zipCode;
        $this->location = $location;
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
}