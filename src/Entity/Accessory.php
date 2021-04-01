<?php

namespace App\Entity;

use App\Repository\AccessoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccessoryRepository::class)
 */
class Accessory
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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="accessories")
     */
    private $mark;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string")
     */
    private $itemImg;

    /**
     * @return mixed
     */
    public function getItemImg()
    {
        return $this->itemImg;
    }

    /**
     * @param mixed $itemImg
     */
    public function setItemImg($itemImg): void
    {
        $this->itemImg = $itemImg;
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

    public function getMark(): ?mark
    {
        return $this->mark;
    }

    public function setMark(?mark $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @param mixed $year
     */
    public function setYear($year): void
    {
        $this->year = $year;
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
}
