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
    private $latitude;

    /**
     * @ORM\Column(type="string")
     */
    private $longitude;

    /**
     * @ORM\Column(type="string")
     */
    private $full_adress_fr;

    /**
     * @ORM\Column(type="string")
     */
    private $full_adress_en;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $create_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $delete_at;

    /**
     * @ORM\Column(type="string")
     */
    private $placePDF;

    /**
     * @ORM\ManyToMany(targetEntity=PlaceExtra::class, mappedBy="Place")
     */
    private $Place;

    public function __construct()
    {
        $this->promotion = new ArrayCollection();
        $this->promotion_departure = new ArrayCollection();
        $this->Place = new ArrayCollection();
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


    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param mixed $latitude
     */
    public function setLatitude($latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param mixed $longitude
     */
    public function setLongitude($longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return mixed
     */
    public function getFullAdressFr()
    {
        return $this->full_adress_fr;
    }

    /**
     * @param mixed $full_adress_fr
     */
    public function setFullAdressFr($full_adress_fr): void
    {
        $this->full_adress_fr = $full_adress_fr;
    }

    /**
     * @return mixed
     */
    public function getFullAdressEn()
    {
        return $this->full_adress_en;
    }

    /**
     * @param mixed $full_adress_en
     */
    public function setFullAdressEn($full_adress_en): void
    {
        $this->full_adress_en = $full_adress_en;
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
    public function getDeleteAt()
    {
        return $this->delete_at;
    }

    /**
     * @param mixed $delete_at
     */
    public function setDeleteAt($delete_at): void
    {
        $this->delete_at = $delete_at;
    }

    /**
     * @return Collection|PlaceExtra[]
     */
    public function getPlace(): Collection
    {
        return $this->Place;
    }

    public function addPlace(PlaceExtra $place): self
    {
        if (!$this->Place->contains($place)) {
            $this->Place[] = $place;
            $place->addPlace($this);
        }

        return $this;
    }

    public function removePlace(PlaceExtra $place): self
    {
        if ($this->Place->removeElement($place)) {
            $place->removePlace($this);
        }

        return $this;
    }
}
