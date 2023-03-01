<?php

namespace App\Entity;

use App\Repository\FileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FileRepository::class)]
class File
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?PostFile $postImages = null;

    #[ORM\OneToOne(mappedBy: 'file', cascade: ['persist', 'remove'])]
    private ?CommentFile $commentImages = null;

    public function __construct()
    {}

    public function getId(): ?int
    {
        return $this->id;
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
     * @return PostFile
     */
    public function getPostImages(): PostFile
    {
        return $this->postImages;
    }





    public function setPostImages(?PostFile $postImages): self
    {
        // unset the owning side of the relation if necessary
        if ($postImages === null && $this->postImages !== null) {
            $this->postImages->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($postImages !== null && $postImages->getImage() !== $this) {
            $postImages->setImage($this);
        }

        $this->postImages = $postImages;

        return $this;
    }

    public function setCommentImages(?CommentFile $commentImages): self
    {
        // unset the owning side of the relation if necessary
        if ($commentImages === null && $this->commentImages !== null) {
            $this->commentImages->setFile(null);
        }

        // set the owning side of the relation if necessary
        if ($commentImages !== null && $commentImages->getFile() !== $this) {
            $commentImages->setFile($this);
        }

        $this->commentImages = $commentImages;

        return $this;
    }
}
