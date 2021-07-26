<?php

namespace App\Entity;

use App\Repository\PriceSupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PriceSupplierRepository::class)
 */
class PriceSupplier
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
    private $price;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end;

    /**
     * @ORM\Column(type="date")
     */
    private $date_start_delivery;

    /**
     * @ORM\Column(type="date")
     */
    private $date_end_delivery;

    /**
     * @ORM\OneToMany(targetEntity=Cars::class, mappedBy="priceSupplier")
     */
    private $car;

    /**
     * @ORM\OneToMany(targetEntity=SliceSupplier::class, mappedBy="price")
     */
    private $slices;

    /**
     * @ORM\ManyToOne(targetEntity=Price::class, inversedBy="priceSupplier")
     */
    private $price_customer;

    public function __construct()
    {
        $this->car = new ArrayCollection();
        $this->slices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): self
    {
        $this->date_start = $date_start;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(\DateTimeInterface $date_end): self
    {
        $this->date_end = $date_end;

        return $this;
    }

    public function getDateStartDelivery(): ?\DateTimeInterface
    {
        return $this->date_start_delivery;
    }

    public function setDateStartDelivery(\DateTimeInterface $date_start_delivery): self
    {
        $this->date_start_delivery = $date_start_delivery;

        return $this;
    }

    public function getDateEndDelivery(): ?\DateTimeInterface
    {
        return $this->date_end_delivery;
    }

    public function setDateEndDelivery(\DateTimeInterface $date_end_delivery): self
    {
        $this->date_end_delivery = $date_end_delivery;

        return $this;
    }

    /**
     * @return Collection|Cars[]
     */
    public function getCar(): Collection
    {
        return $this->car;
    }

    public function addCar(Cars $car): self
    {
        if (!$this->car->contains($car)) {
            $this->car[] = $car;
            $car->setPrice($this);
        }

        return $this;
    }

    public function removeCar(Cars $car): self
    {
        if ($this->car->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getPrice() === $this) {
                $car->setPrice(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Slice[]
     */
    public function getSlices(): Collection
    {
        return $this->slices;
    }

    public function addSlice(Slice $slice): self
    {
        if (!$this->slices->contains($slice)) {
            $this->slices[] = $slice;
            $slice->setTarif($this);
        }

        return $this;
    }

    public function removeSlice(Slice $slice): self
    {
        if ($this->slices->removeElement($slice)) {
            // set the owning side to null (unless already changed)
            if ($slice->getTarif() === $this) {
                $slice->setTarif(null);
            }
        }

        return $this;
    }


    /**
     * @return mixed
     */
    public function getPriceCustomer()
    {
        return $this->price_customer;
    }

    /**
     * @param mixed $price_customer
     */
    public function setPriceCustomer($price_customer): void
    {
        $this->price_customer = $price_customer;
    }

}
