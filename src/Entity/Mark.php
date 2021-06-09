<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MarkRepository::class)
 */
class Mark
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;


    /**
     * @ORM\OneToMany(targetEntity=Cars::class, mappedBy="mark")
     */
    private $cars;

    /**
     * @ORM\OneToMany(targetEntity=Range::class, mappedBy="mark")
     */
    private $ranges;

    /**
     * @ORM\Column(type="string")
     */
    private $markImg;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $margin;

    /**
     * @ORM\OneToMany(targetEntity=Accessory::class, mappedBy="mark")
     */
    private $accessories;

    /**
     * @ORM\OneToMany(targetEntity=Promotions::class, mappedBy="mark")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity=Slice::class, mappedBy="mark")
     */
    private $slices;

    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->ranges = new ArrayCollection();
        $this->accessories = new ArrayCollection();
        $this->promotion = new ArrayCollection();
        $this->slices = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getMarkImg()
    {
        return $this->markImg;
    }

    /**
     * @param mixed $markImg
     */
    public function setMarkImg($markImg): void
    {
        $this->markImg = $markImg;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection|Cars[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(cars $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setMark($this);
        }

        return $this;
    }

    public function removeCar(cars $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getMark() === $this) {
                $car->setMark(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Range[]
     */
    public function getRanges(): Collection
    {
        return $this->ranges;
    }

    public function addRange(Range $range): self
    {
        if (!$this->ranges->contains($range)) {
            $this->ranges[] = $range;
            $range->setMark($this);
        }

        return $this;
    }

    public function removeRange(Range $range): self
    {
        if ($this->ranges->removeElement($range)) {
            // set the owning side to null (unless already changed)
            if ($range->getMark() === $this) {
                $range->setMark(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Accessory[]
     */
    public function getAccessories(): Collection
    {
        return $this->accessories;
    }

    public function addAccessory(Accessory $accessory): self
    {
        if (!$this->accessories->contains($accessory)) {
            $this->accessories[] = $accessory;
            $accessory->setMark($this);
        }

        return $this;
    }

    public function removeAccessory(Accessory $accessory): self
    {
        if ($this->accessories->removeElement($accessory)) {
            // set the owning side to null (unless already changed)
            if ($accessory->getMark() === $this) {
                $accessory->setMark(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMargin()
    {
        return $this->margin;
    }

    /**
     * @param mixed $margin
     */
    public function setMargin($margin): void
    {
        $this->margin = $margin;
    }

    /**
     * @return ArrayCollection
     */
    public function getPromotion(): ArrayCollection
    {
        return $this->promotion;
    }

    /**
     * @param ArrayCollection $promotion
     */
    public function setPromotion(ArrayCollection $promotion): void
    {
        $this->promotion = $promotion;
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
            $slice->setMark($this);
        }

        return $this;
    }

    public function removeSlice(Slice $slice): self
    {
        if ($this->slices->removeElement($slice)) {
            // set the owning side to null (unless already changed)
            if ($slice->getMark() === $this) {
                $slice->setMark(null);
            }
        }

        return $this;
    }

}
