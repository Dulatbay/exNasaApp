<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Content = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[MaxDepth(1)]
    private ?user $userId = null;



    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    #[MaxDepth(1)]
    private ?Post $postId = null;

    #[MaxDepth(1)]
    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: file::class)]
    private Collection $files;



    public function __construct()
    {
        $this->files = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->Content;
    }

    public function setContent(?string $Content): self
    {
        $this->Content = $Content;

        return $this;
    }

    public function getUserId(): ?user
    {
        return $this->userId;
    }

    public function setUserId(?user $userId): self
    {
        $this->userId = $userId;

        return $this;
    }


    public function getPostId(): ?Post
    {
        return $this->postId;
    }

    public function setPostId(?Post $postId): self
    {
        $this->postId = $postId;

        return $this;
    }

    /**
     * @return Collection<int, file>
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(file $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files->add($file);
            $file->setComment($this);
        }

        return $this;
    }

    public function removeFile(file $file): self
    {
        if ($this->files->removeElement($file)) {
            // set the owning side to null (unless already changed)
            if ($file->getComment() === $this) {
                $file->setComment(null);
            }
        }

        return $this;
    }

}
