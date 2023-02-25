<?php

namespace App\Entity;

use App\Repository\RoverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoverRepository::class)]
class Rover
{
    #[ORM\Id]
    #[ORM\Column]
    public ?int $id = null;

    #[ORM\Column(length: 255)]
    public ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    public ?\DateTimeInterface $landing_date = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    public ?\DateTimeInterface $launch_date = null;

    #[ORM\Column(length: 30)]
    public ?string $status = null;

    #[ORM\Column]
    public ?int $max_sol = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    public ?\DateTimeInterface $max_date = null;

    #[ORM\Column]
    public ?int $total_photos = null;

    #[ORM\ManyToMany(targetEntity: RoverCamera::class, inversedBy: 'rover_id', cascade: ["persist"])]
    public Collection $roverCameras;

    public function __construct()
    {
        $this->roverCameras = new ArrayCollection();
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

    public function getLandingDate(): ?\DateTimeInterface
    {
        return $this->landing_date;
    }

    public function setLandingDate(\DateTimeInterface $landing_date): self
    {
        $this->landing_date = $landing_date;

        return $this;
    }

    public function getLaunchDate(): ?\DateTimeInterface
    {
        return $this->launch_date;
    }

    public function setLaunchDate(\DateTimeInterface $launch_date): self
    {
        $this->launch_date = $launch_date;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getMaxSol(): ?int
    {
        return $this->max_sol;
    }

    public function setMaxSol(int $max_sol): self
    {
        $this->max_sol = $max_sol;

        return $this;
    }

    public function getMaxDate(): ?\DateTimeInterface
    {
        return $this->max_date;
    }

    public function setMaxDate(\DateTimeInterface $max_date): self
    {
        $this->max_date = $max_date;

        return $this;
    }

    public function getTotalPhotos(): ?int
    {
        return $this->total_photos;
    }

    public function setTotalPhotos(int $total_photos): self
    {
        $this->total_photos = $total_photos;

        return $this;
    }




    public function getRoverCameras(): Collection
    {
        return $this->roverCameras;
    }

    public function addRoverCamera(RoverCamera $roverCamera): self
    {
        if (!$this->roverCameras->contains($roverCamera)) {
            $this->roverCameras->add($roverCamera);
            $roverCamera->addRoverId($this);
        }

        return $this;
    }

    public function removeRoverCamera(RoverCamera $roverCamera): self
    {
        if ($this->roverCameras->removeElement($roverCamera)) {
            $roverCamera->removeRoverId($this);
        }

        return $this;
    }
}
