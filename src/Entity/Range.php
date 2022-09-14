<?php

namespace App\Entity;

use App\Repository\RangeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RangeRepository::class)
 * @ORM\Table(name="`range`")
 */
class Range
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Cars::class, mappedBy="ranges")
     */
    private $cars;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="ranges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="string")
     */
    private $rangeImg;

    /**
     * @ORM\ManyToMany(targetEntity=Promotions::class, mappedBy="range_promo")
     */
    private $promotions;

    /**
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $extraCost;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $create_at;

    /**
     * @ORM\Column(type="date" , nullable = true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $deleted_at;


    public function __construct()
    {
        $this->cars = new ArrayCollection();
        $this->promotions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Cars[]
     */
    public function getCars(): Collection
    {
        return $this->cars;
    }

    public function addCar(Cars $car): self
    {
        if (!$this->cars->contains($car)) {
            $this->cars[] = $car;
            $car->setRanges($this);
        }

        return $this;
    }

    public function removeCar(Cars $car): self
    {
        if ($this->cars->removeElement($car)) {
            // set the owning side to null (unless already changed)
            if ($car->getRanges() === $this) {
                $car->setRanges(null);
            }
        }

        return $this;
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
     * @return mixed
     */
    public function getRangeImg()
    {
        return $this->rangeImg;
    }

    /**
     * @param mixed $rangeImg
     */
    public function setRangeImg($rangeImg): void
    {
        $this->rangeImg = $rangeImg;
    }

    /**
     * @return Collection|Promotions[]
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotions $promotion): self
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions[] = $promotion;
            $promotion->addRangePromo($this);
        }

        return $this;
    }

    public function removePromotion(Promotions $promotion): self
    {
        if ($this->promotions->removeElement($promotion)) {
            $promotion->removeRangePromo($this);
        }

        return $this;
    }


    /**
     * @return mixed
     */
    public function getExtraCost()
    {
        return $this->extraCost;
    }

    /**
     * @param mixed $extraCost
     */
    public function setExtraCost($extraCost): void
    {
        $this->extraCost = $extraCost;
    }

    /**
     * @return mixed
     */
    public function getCreateAt()
    {
        return $this->create_at;
    }

    /**
     * @param mixed $create_at
     */
    public function setCreateAt($create_at): void
    {
        $this->create_at = $create_at;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->update_at;
    }

    /**
     * @param mixed $update_at
     */
    public function setUpdateAt($update_at): void
    {
        $this->update_at = $update_at;
    }

    /**
     * @return mixed
     */
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at): void
    {
        $this->deleted_at = $deleted_at;
    }
}
