<?php

namespace App\Entity;

use App\Repository\PromotionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime as ConstraintsDateTime;

/**
 * @ORM\Entity(repositoryClass=PromotionsRepository::class)
 */
class Promotions
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="date")
     */
    private $start_date;

    /**
     * @ORM\Column(type="date")
     */
    private $end_date;

    /**
     * @ORM\Column(type="date")
     */
    private $start_delivery;

    /**
     * @ORM\Column(type="date")
     */
    private $end_delivery;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="promotion")
     */
    private $place_delivery;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="promotion")
     */
    private $mark;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="promotion_departure")
     */
    private $place_departure;

    /**
     * @ORM\ManyToOne(targetEntity=TypePromo::class, inversedBy="promotions")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity=Range::class, inversedBy="promotions")
     */
    private $range_promo;

    public function __construct()
    {
        $this->range_promo = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->start_date;
    }

    public function setStartDate(\DateTimeInterface $start_date): self
    {
        $this->start_date = $start_date;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->end_date;
    }

    public function setEndDate(\DateTimeInterface $end_date): self
    {
        $this->end_date = $end_date;

        return $this;
    }

    public function getStartDelivery(): ?\DateTimeInterface
    {
        return $this->start_delivery;
    }

    public function setStartDelivery(\DateTimeInterface $start_delivery): self
    {
        $this->start_delivery = $start_delivery;

        return $this;
    }

    public function getEndDelivery(): ?\DateTimeInterface
    {
        return $this->end_delivery;
    }

    public function setEndDelivery(\DateTimeInterface $end_delivery): self
    {
        $this->end_delivery = $end_delivery;

        return $this;
    }

    public function getPlaceDelivery(): ?Place
    {
        return $this->place_delivery;
    }

    public function setPlaceDelivery(?Place $place_delivery): self
    {
        $this->place_delivery = $place_delivery;

        return $this;
    }

    public function getPlaceDeparture(): ?Place
    {
        return $this->place_departure;
    }

    public function setPlaceDeparture(?Place $place_departure): self
    {
        $this->place_departure = $place_departure;

        return $this;
    }

    public function getType(): ?TypePromo
    {
        return $this->type;
    }

    public function setType(?TypePromo $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Range[]
     */
    public function getRangePromo(): Collection
    {
        return $this->range_promo;
    }

    public function addRangePromo(Range $rangePromo): self
    {
        if (!$this->range_promo->contains($rangePromo)) {
            $this->range_promo[] = $rangePromo;
        }

        return $this;
    }

    public function removeRangePromo(Range $rangePromo): self
    {
        $this->range_promo->removeElement($rangePromo);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark($mark): void
    {
        $this->mark = $mark;
    }
    
}
