<?php

namespace App\Entity;

use App\Repository\CarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PhpParser\Node\Scalar\String_;

/**
 * @ORM\Entity(repositoryClass=CarsRepository::class)
 */
class Cars
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $margin;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $fuel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $roofRack;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $chains;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sellingPrice;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $years;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $passenger;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $door;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $transmission;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $clim;

    /**
     * @ORM\Column(type="boolean")
     */
    private $contactActived = false;


    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $co2;

    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $luggage;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity=Range::class, inversedBy="cars")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ranges;

    /**
     * @ORM\Column(type="array")
     */
    protected $items;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $is_online;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="string")
     */
    private $carImg;

    /**
     * @ORM\ManyToOne(targetEntity=Price::class, inversedBy="car")
     */
    private $price;

    public function __construct()
    {
        $this->items = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCarImg()
    {
        return $this->carImg;
    }

    /**
     * @param mixed $carImg
     */
    public function setCarImg($carImg): void
    {
        $this->carImg = $carImg;
    }

    /**
     * @return mixed
     */
    public function getLuggage()
    {
        return $this->luggage;
    }

    /**
     * @param mixed $luggage
     */
    public function setLuggage($luggage): void
    {
        $this->luggage = $luggage;
    }

    /**
     * @return mixed
     */
    public function getClim()
    {
        return $this->clim;
    }

    /**
     * @param mixed $clim
     */
    public function setClim($clim): void
    {
        $this->clim = $clim;
    }

    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * @param mixed $transmission
     */
    public function setTransmission($transmission): void
    {
        $this->transmission = $transmission;
    }

    /**
     * @return mixed
     */
    public function getCo2()
    {
        return $this->co2;
    }

    /**
     * @param mixed $co2
     */
    public function setCo2($co2): void
    {
        $this->co2 = $co2;
    }

    /**
     * @return mixed
     */
    public function getDoor()
    {
        return $this->door;
    }

    /**
     * @param mixed $door
     */
    public function setDoor($door): void
    {
        $this->door = $door;
    }

    /**
     * @return mixed
     */
    public function getPassenger()
    {
        return $this->passenger;
    }

    /**
     * @param mixed $passenger
     */
    public function setPassenger($passenger): void
    {
        $this->passenger = $passenger;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMargin(): ?int
    {
        return $this->margin;
    }

    public function setMargin(?int $margin): self
    {
        $this->margin = $margin;

        return $this;
    }

    public function getFuel(): ?string
    {
        return $this->fuel;
    }

    public function setFuel($fuel): self
    {
        $this->fuel = $fuel;

        return $this;
    }

    public function getRoofRack(): ?int
    {
        return $this->roofRack;
    }

    public function setRoofRack(int $roofRack): self
    {
        $this->roofRack = $roofRack;

        return $this;
    }

    public function getChains(): ?int
    {
        return $this->chains;
    }

    public function setChains(?int $chains): self
    {
        $this->chains = $chains;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getYears()
    {
        return $this->years;
    }

    /**
     * @param mixed $years
     */
    public function setYears($years): void
    {
        $this->years = $years;
    }

    /**
     * @return mixed
     */
    public function getSellingPrice()
    {
        return $this->sellingPrice;
    }

    /**
     * @param mixed $sellingPrice
     */
    public function setSellingPrice($sellingPrice): void
    {
        $this->sellingPrice = $sellingPrice;
    }

    public function getMark(): ?Mark
    {
        return $this->mark;
    }

    public function setMark(?Mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getRanges(): ?Range
    {
        return $this->ranges;
    }

    public function setRanges(?Range $ranges): self
    {
        $this->ranges = $ranges;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param mixed $items
     */
    public function setItems($items): void
    {
        $this->items = $items;
    }

    /**
     * @return mixed
     */
    public function getIsOnline()
    {
        return $this->is_online;
    }

    /**
     * @param mixed $is_online
     */
    public function setIsOnline($is_online): void
    {
        $this->is_online = $is_online;
    }

    /**
     * @return mixed
     */
    public function getDateStart()
    {
        return $this->date_start;
    }

    /**
     * @param mixed $date_start
     */
    public function setDateStart($date_start): void
    {
        $this->date_start = $date_start;
    }

    /**
     * @return mixed
     */
    public function getDateEnd()
    {
        return $this->date_end;
    }

    /**
     * @param mixed $date_end
     */
    public function setDateEnd($date_end): void
    {
        $this->date_end = $date_end;
    }

    public function getPrice(): ?Price
    {
        return $this->price;
    }

    public function setPrice(?Price $price): self
    {
        $this->price = $price;

        return $this;
    }


    /**
     * @return bool
     */
    public function isContactActived(): bool
    {
        return $this->contactActived;
    }

    /**
     * @param bool $contactActived
     */
    public function setContactActived(bool $contactActived): void
    {
        $this->contactActived = $contactActived;
    }


    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }
}
