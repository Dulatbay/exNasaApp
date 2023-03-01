<?php

namespace App\Entity;

use App\Repository\SubscriptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SubscriptionRepository::class)]
class Subscription
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'subscriptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $subscriber = null;

    #[ORM\ManyToOne(inversedBy: 'subscribers')]
    private ?User $subscribeTo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubscriber(): ?User
    {
        return $this->subscriber;
    }

    public function setSubscriber(?User $subscriber): self
    {
        $this->subscriber = $subscriber;

        return $this;
    }

    public function getSubscribeTo(): ?User
    {
        return $this->subscribeTo;
    }

    public function setSubscribeTo(?User $subscribeTo): self
    {
        $this->subscribeTo = $subscribeTo;

        return $this;
    }
}
