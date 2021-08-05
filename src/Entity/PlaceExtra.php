<?php

namespace App\Entity;

use App\Repository\PlaceExtraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceExtraRepository::class)
 */
class PlaceExtra
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="extra_place")
     */
    private $brand_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $extra_1;

    /**
     * @ORM\Column(type="integer")
     */
    private $extra_2;

    /**
     * @ORM\Column(type="integer")
     */
    private $days_limit;

    /**
     * @ORM\Column(type="date")
     */
    private $create_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $deleted_at;

    /**
     * @ORM\ManyToMany(targetEntity=Place::class, inversedBy="Place")
     */
    private $Place;

    public function __construct()
    {
        $this->Place = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExtra1(): ?int
    {
        return $this->extra_1;
    }

    public function setExtra1(int $extra_1): self
    {
        $this->extra_1 = $extra_1;

        return $this;
    }

    public function getExtra2(): ?int
    {
        return $this->extra_2;
    }

    public function setExtra2(int $extra_2): self
    {
        $this->extra_2 = $extra_2;

        return $this;
    }

    public function getDaysLimit(): ?int
    {
        return $this->days_limit;
    }

    public function setDaysLimit(int $days_limit): self
    {
        $this->days_limit = $days_limit;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection|Place[]
     */
    public function getPlace(): Collection
    {
        return $this->Place;
    }

    public function addPlace(Place $place): self
    {
        if (!$this->Place->contains($place)) {
            $this->Place[] = $place;
        }

        return $this;
    }

    public function removePlace(Place $place): self
    {
        $this->Place->removeElement($place);

        return $this;
    }


    /**
     * @return mixed
     */
    public function getBrandId()
    {
        return $this->brand_id;
    }

    /**
     * @param mixed $brand_id
     */
    public function setBrandId($brand_id): void
    {
        $this->brand_id = $brand_id;
    }
}
