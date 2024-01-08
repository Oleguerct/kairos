<?php


namespace App\Service\ForecastAPIConnection;


interface ForecastAPIConnectionInterface
{
    public function getForecastsDTOs(string $location);
}