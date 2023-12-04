<?php

namespace App\Entity;

use App\Repository\WeatherForecastRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeatherForecastRepository::class)]
class WeatherForecast
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $location = null;

    #[ORM\Column]
    private ?float $tempMax = null;

    #[ORM\Column]
    private ?float $tempMin = null;

    #[ORM\Column]
    private ?float $tempMean = null;

    #[ORM\Column]
    private ?float $humidity = null;

    #[ORM\Column]
    private ?float $precipProb = null;

    #[ORM\Column]
    private ?float $windSpeed = null;

    #[ORM\Column]
    private ?float $cloudCover = null;

    #[ORM\Column]
    private ?int $uvIndex = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $day = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getTempMax(): ?float
    {
        return $this->tempMax;
    }

    public function setTempMax(float $tempMax): static
    {
        $this->tempMax = $tempMax;

        return $this;
    }

    public function getTempMin(): ?float
    {
        return $this->tempMin;
    }

    public function setTempMin(float $tempMin): static
    {
        $this->tempMin = $tempMin;

        return $this;
    }

    public function getTempMean(): ?float
    {
        return $this->tempMean;
    }

    public function setTempMean(float $tempMean): static
    {
        $this->tempMean = $tempMean;

        return $this;
    }

    public function getHumidity(): ?float
    {
        return $this->humidity;
    }

    public function setHumidity(float $humidity): static
    {
        $this->humidity = $humidity;

        return $this;
    }

    public function getPrecipProb(): ?float
    {
        return $this->precipProb;
    }

    public function setPrecipProb(float $precipProb): static
    {
        $this->precipProb = $precipProb;

        return $this;
    }

    public function getWindSpeed(): ?float
    {
        return $this->windSpeed;
    }

    public function setWindSpeed(float $windSpeed): static
    {
        $this->windSpeed = $windSpeed;

        return $this;
    }

    public function getCloudCover(): ?float
    {
        return $this->cloudCover;
    }

    public function setCloudCover(float $cloudCover): static
    {
        $this->cloudCover = $cloudCover;

        return $this;
    }

    public function getUvIndex(): ?int
    {
        return $this->uvIndex;
    }

    public function setUvIndex(int $uvIndex): static
    {
        $this->uvIndex = $uvIndex;

        return $this;
    }

    public function getDay(): ?\DateTimeInterface
    {
        return $this->day;
    }

    public function setDay(\DateTimeInterface $day): static
    {
        $this->day = $day;

        return $this;
    }
}
