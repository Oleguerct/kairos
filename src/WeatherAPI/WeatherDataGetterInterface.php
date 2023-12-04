<?php


namespace App\WeatherAPI;


interface WeatherDataGetterInterface
{
    public function getByDayAndLocation(\DateTime $date, string $location): void;
}