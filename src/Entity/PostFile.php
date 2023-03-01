<?php

namespace App\Entity;

use App\Repository\PostFileRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostFileRepository::class)]
class PostFile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'postFiles', cascade: ['persist', 'remove'])]
    private ?File $file = null;

    #[ORM\ManyToOne(inversedBy: 'postImages')]
    private ?Post $post = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): ?File
    {
        return $this->file;
    }

    public function setImage(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->post;
    }

    public function setPost(?Post $post): self
    {
        $this->post = $post;

        return $this;
    }
}
