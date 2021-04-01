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
}
