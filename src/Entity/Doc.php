<?php

namespace App\Entity;

use App\Repository\DocRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DocRepository::class)
 */
class Doc
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
    private $Name;

    /**
     * @ORM\ManyToMany(targetEntity=Reason::class, inversedBy="docs")
     */
    private $reason;

    /**
     * @ORM\Column(type="string")
     */
    private $DocImg;

    /**
     * @ORM\Column(type="date")
     */
    private $create_at;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $deleted_at;

    public function __construct()
    {
        $this->reason = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    /**
     * @return Collection<int, Reason>
     */
    public function getReason(): Collection
    {
        return $this->reason;
    }

    public function addReason(Reason $reason): self
    {
        if (!$this->reason->contains($reason)) {
            $this->reason[] = $reason;
        }

        return $this;
    }

    public function removeReason(Reason $reason): self
    {
        $this->reason->removeElement($reason);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDocImg()
    {
        return $this->DocImg;
    }

    /**
     * @param mixed $DocImg
     */
    public function setDocImg($DocImg): void
    {
        $this->DocImg = $DocImg;
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
