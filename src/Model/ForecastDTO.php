<?php


namespace App\Model;


use Doctrine\DBAL\Types\Types;

class ForecastDTO
{

    public function __construct(
        private string $location,
        private float $tempMax,
        private float $tempMin,
        private float $tempMean,
        private float $humidity,
        private float $precipProb,
        private float $windSpeed,
        private float $cloudCover,
        private int $uvIndex,
        private \DateTimeInterface $day
    )
    {}

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @return float
     */
    public function getTempMax(): float
    {
        return $this->tempMax;
    }

    /**
     * @return float
     */
    public function getTempMin(): float
    {
        return $this->tempMin;
    }

    /**
     * @return float
     */
    public function getTempMean(): float
    {
        return $this->tempMean;
    }

    /**
     * @return float
     */
    public function getHumidity(): float
    {
        return $this->humidity;
    }

    /**
     * @return float
     */
    public function getPrecipProb(): float
    {
        return $this->precipProb;
    }

    /**
     * @return float
     */
    public function getWindSpeed(): float
    {
        return $this->windSpeed;
    }

    /**
     * @return float
     */
    public function getCloudCover(): float
    {
        return $this->cloudCover;
    }

    /**
     * @return int
     */
    public function getUvIndex(): int
    {
        return $this->uvIndex;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getDay(): \DateTimeInterface
    {
        return $this->day;
    }

}