<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 */
class Blog
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $author;

    /**
     * @ORM\Column(type="date")
     */
    private $create_at;

    /**
     * @ORM\Column(type="string")
     */
    private $PostImg;

    /**
     * @ORM\ManyToOne(targetEntity=CategoryPost::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categoryPost;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="date", nullable = true)
     */
    private $deleted_at;

    /**
     * @return mixed
     */
    public function getCategoryPost()
    {
        return $this->categoryPost;
    }

    /**
     * @param mixed $categoryPost
     */
    public function setCategoryPost($categoryPost): void
    {
        $this->categoryPost = $categoryPost;
    }

    /**
     * @return mixed
     */
    public function getPostImg()
    {
        return $this->PostImg;
    }

    /**
     * @param mixed $PostImg
     */
    public function setPostImg($PostImg): void
    {
        $this->PostImg = $PostImg;
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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
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
