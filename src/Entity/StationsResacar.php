<?php

namespace App\Entity;

use App\Repository\StationsResacarRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StationsResacarRepository::class)
 */
class StationsResacar
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $stations_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $station_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $station_city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $country_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $country_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address_1;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fax;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $self_service = false;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_min;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date_max;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hour_min;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hour_max;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStationsId(): ?int
    {
        return $this->stations_id;
    }

    public function setStationsId(int $stations_id): self
    {
        $this->stations_id = $stations_id;

        return $this;
    }

    public function getStationName(): ?string
    {
        return $this->station_name;
    }

    public function setStationName(string $station_name): self
    {
        $this->station_name = $station_name;

        return $this;
    }

    public function getStationCity(): ?string
    {
        return $this->station_city;
    }

    public function setStationCity(string $station_city): self
    {
        $this->station_city = $station_city;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->country_name;
    }

    public function setCountryName(string $country_name): self
    {
        $this->country_name = $country_name;

        return $this;
    }

    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    public function setCountryId(int $country_id): self
    {
        $this->country_id = $country_id;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->address_1;
    }

    /**
     * @param mixed $address_1
     */
    public function setAddress1($address_1): void
    {
        $this->address_1 = $address_1;
    }

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax): void
    {
        $this->fax = $fax;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isSelfService(): bool
    {
        return $this->self_service;
    }

    /**
     * @param bool $self_service
     */
    public function setSelfService(bool $self_service): void
    {
        $this->self_service = $self_service;
    }


    /**
     * @return mixed
     */
    public function getDateMin()
    {
        return $this->date_min;
    }

    /**
     * @param mixed $date_min
     */
    public function setDateMin($date_min): void
    {
        $this->date_min = $date_min;
    }

    /**
     * @return mixed
     */
    public function getDateMax()
    {
        return $this->date_max;
    }

    /**
     * @param mixed $date_max
     */
    public function setDateMax($date_max): void
    {
        $this->date_max = $date_max;
    }

    /**
     * @return mixed
     */
    public function getHourMin()
    {
        return $this->hour_min;
    }

    /**
     * @param mixed $hour_min
     */
    public function setHourMin($hour_min): void
    {
        $this->hour_min = $hour_min;
    }

    /**
     * @return mixed
     */
    public function getHourMax()
    {
        return $this->hour_max;
    }

    /**
     * @param mixed $hour_max
     */
    public function setHourMax($hour_max): void
    {
        $this->hour_max = $hour_max;
    }


    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }
}
