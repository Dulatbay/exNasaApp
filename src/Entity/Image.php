<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Post::class, inversedBy: 'images')]
    private Collection $postImages;

    #[ORM\ManyToMany(targetEntity: Comment::class, mappedBy: 'Images')]
    private Collection $commentImages;

    public function __construct()
    {
        $this->postImages = new ArrayCollection();
        $this->commentImages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPostImages(): Collection
    {
        return $this->postImages;
    }

    public function addPostImage(Post $postImage): self
    {
        if (!$this->postImages->contains($postImage)) {
            $this->postImages->add($postImage);
        }

        return $this;
    }

    public function removePostImage(Post $postImage): self
    {
        $this->postImages->removeElement($postImage);

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getCommentImages(): Collection
    {
        return $this->commentImages;
    }

    public function addCommentImage(Comment $commentImage): self
    {
        if (!$this->commentImages->contains($commentImage)) {
            $this->commentImages->add($commentImage);
            $commentImage->addImage($this);
        }

        return $this;
    }

    public function removeCommentImage(Comment $commentImage): self
    {
        if ($this->commentImages->removeElement($commentImage)) {
            $commentImage->removeImage($this);
        }

        return $this;
    }
}
