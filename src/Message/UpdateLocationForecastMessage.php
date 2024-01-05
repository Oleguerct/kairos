<?php


namespace App\Message;


class UpdateLocationForecastMessage
{
    public function __construct(
        private string $location
    ){
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}