<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
    private ?user $userId = null;



    #[ORM\OneToMany(mappedBy: 'comment', targetEntity: CommentFile::class)]
    private Collection $commentImages;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Post $postId = null;



    public function __construct()
    {
        $this->commentImages = new ArrayCollection();
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

    public function getPostComments(): ?PostComment
    {
        return $this->postComment;
    }

    public function setPostComments(?PostComment $postComment): self
    {
        // unset the owning side of the relation if necessary
        if ($postComment === null && $this->postComment !== null) {
            $this->postComment->setCommentId(null);
        }

        // set the owning side of the relation if necessary
        if ($postComment !== null && $postComment->getCommentId() !== $this) {
            $postComment->setCommentId($this);
        }

        $this->postComments = $postComment;

        return $this;
    }

    /**
     * @return Collection<int, CommentFile>
     */
    public function getCommentImages(): Collection
    {
        return $this->commentImages;
    }

    public function addCommentImage(CommentFile $commentImage): self
    {
        if (!$this->commentImages->contains($commentImage)) {
            $this->commentImages->add($commentImage);
            $commentImage->setComment($this);
        }

        return $this;
    }

    public function removeCommentImage(CommentFile $commentImage): self
    {
        if ($this->commentImages->removeElement($commentImage)) {
            // set the owning side to null (unless already changed)
            if ($commentImage->getComment() === $this) {
                $commentImage->setComment(null);
            }
        }

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

}
