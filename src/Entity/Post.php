<?php

namespace App\Entity;

use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PostRepository::class)]
class Post
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'posts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $userId = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contentText = null;
    #[ORM\OneToMany(mappedBy: 'post', targetEntity: PostFile::class)]
    private Collection $postFiles;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'likes')]
    private Collection $likes;




    #[ORM\OneToMany(mappedBy: 'postId', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;




    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->postFiles = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContentText(): ?string
    {
        return $this->contentText;
    }

    public function setContentText(?string $contentText): self
    {
        $this->contentText = $contentText;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes->add($like);
            $like->addLike($this);
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        if ($this->likes->removeElement($like)) {
            $like->removeLike($this);
        }

        return $this;
    }


    /**
     * @return Collection<int, PostFile>
     */
    public function getPostImages(): Collection
    {
        return $this->postFiles;
    }

    public function addPostImage(PostFile $postImage): self
    {
        if (!$this->postFiles->contains($postImage)) {
            $this->postFiles->add($postImage);
            $postImage->setPost($this);
        }

        return $this;
    }

    public function removePostImage(PostFile $postImage): self
    {
        if ($this->postFiles->removeElement($postImage)) {
            // set the owning side to null (unless already changed)
            if ($postImage->getPost() === $this) {
                $postImage->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setPostId($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getPostId() === $this) {
                $comment->setPostId(null);
            }
        }

        return $this;
    }



}
