<?php

namespace App\Entity;

use App\Repository\SliceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SliceRepository::class)
 */
class Slice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $code_price;

    /**
     * @ORM\Column(type="integer")
     */
    private $days_min;

    /**
     * @ORM\Column(type="integer")
     */
    private $days_max;

    /**
     * @ORM\Column(type="integer")
     */
    private $value;

    /**
     * @ORM\Column(type="integer")
     */
    private $days;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $operators;

    /**
     * @ORM\ManyToOne(targetEntity=Price::class, inversedBy="slices")
     */
    private $tarif;

    /**
     * @ORM\ManyToOne(targetEntity=Mark::class, inversedBy="slices")
     */
    private $mark;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePrice(): ?string
    {
        return $this->code_price;
    }

    public function setCodePrice(?string $code_price): self
    {
        $this->code_price = $code_price;

        return $this;
    }

    public function getDaysMin(): ?int
    {
        return $this->days_min;
    }

    public function setDaysMin(int $days_min): self
    {
        $this->days_min = $days_min;

        return $this;
    }

    public function getDaysMax(): ?int
    {
        return $this->days_max;
    }

    public function setDaysMax(int $days_max): self
    {
        $this->days_max = $days_max;

        return $this;
    }

    public function getTarif(): ?Price
    {
        return $this->tarif;
    }

    public function setTarif(?Price $tarif): self
    {
        $this->tarif = $tarif;

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


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     */
    public function setValue($value): void
    {
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days): void
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getOperators()
    {
        return $this->operators;
    }

    /**
     * @param mixed $operators
     */
    public function setOperators($operators): void
    {
        $this->operators = $operators;
    }
}
