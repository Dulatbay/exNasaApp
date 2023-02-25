<?php

namespace App\Entity;

use App\Repository\RoverCameraRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoverCameraRepository::class)]
class RoverCamera
{
    #[ORM\Id]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Rover::class, mappedBy: 'roverCameras',cascade: ["persist"])]
    public Collection $rover_id;

    #[ORM\Column(length: 255)]
    public ?string $full_name = null;

    public function __construct()
    {
        $this->rover_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(int $id): self
    {
         $this->id = $id;

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


    public function getRoverId(): Collection
    {
        return $this->rover_id;
    }

    public function addRoverId(Rover $roverId): self
    {
        if (!$this->rover_id->contains($roverId)) {
            $this->rover_id->add($roverId);
        }

        return $this;
    }

    public function removeRoverId(Rover $roverId): self
    {
        $this->rover_id->removeElement($roverId);

        return $this;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): self
    {
        $this->full_name = $full_name;

        return $this;
    }
}
