<?php

namespace App\Entity;

use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
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
     * @ORM\Column(type="string", length=255)
     */
    private $libelle_en;

    /**
     * @ORM\OneToMany(targetEntity=Promotions::class, mappedBy="place_delivery")
     */
    private $promotion;

    /**
     * @ORM\OneToMany(targetEntity=Promotions::class, mappedBy="place_departure")
     */
    private $promotion_departure;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $placePDF;

    public function __construct()
    {
        $this->promotion = new ArrayCollection();
        $this->promotion_departure = new ArrayCollection();
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
     * @return Collection|Promotions[]
     */
    public function getPromotion(): Collection
    {
        return $this->promotion;
    }

    public function addPromotion(Promotions $promotion): self
    {
        if (!$this->promotion->contains($promotion)) {
            $this->promotion[] = $promotion;
            $promotion->setPlaceDelivery($this);
        }

        return $this;
    }

    public function removePromotion(Promotions $promotion): self
    {
        if ($this->promotion->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getPlaceDelivery() === $this) {
                $promotion->setPlaceDelivery(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promotions[]
     */
    public function getPromotionDeparture(): Collection
    {
        return $this->promotion_departure;
    }

    public function addPromotionDeparture(Promotions $promotionDeparture): self
    {
        if (!$this->promotion_departure->contains($promotionDeparture)) {
            $this->promotion_departure[] = $promotionDeparture;
            $promotionDeparture->setPlaceDeparture($this);
        }

        return $this;
    }

    public function removePromotionDeparture(Promotions $promotionDeparture): self
    {
        if ($this->promotion_departure->removeElement($promotionDeparture)) {
            // set the owning side to null (unless already changed)
            if ($promotionDeparture->getPlaceDeparture() === $this) {
                $promotionDeparture->setPlaceDeparture(null);
            }
        }

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price): void
    {
        $this->price = $price;
    }

    /**
     * @return mixed
     */
    public function getPlacePDF()
    {
        return $this->placePDF;
    }

    /**
     * @param mixed $placePDF
     */
    public function setPlacePDF($placePDF): void
    {
        $this->placePDF = $placePDF;
    }


    /**
     * @return mixed
     */
    public function getLibelleEn()
    {
        return $this->libelle_en;
    }

    /**
     * @param mixed $libelle_en
     */
    public function setLibelleEn($libelle_en): void
    {
        $this->libelle_en = $libelle_en;
    }
}
