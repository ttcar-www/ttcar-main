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
