<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity()]
class Product
{

    #[ORM\Id()]
    #[ORM\GeneratedValue()]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;


    #[ORM\Column(type: "string", length: 180)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 3, max: 180)]
    #[Assert\Regex(pattern: "/^[a-zA-Z]+$/")]
    private ?string $title = null;

    #[ORM\Column(type: "text")]
    #[Assert\Regex(pattern: "/^[a-zA-Z\s]*$/")]
    private ?string $description = null;

    #[ORM\Column(type: "string", unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Regex(pattern: "/^[0-9\-]+$/")]
    private ?string $code = null;

    #[ORM\Column(type: "string", unique: true)]
    #[Assert\NotBlank()]
    #[Assert\Regex(pattern: "/^[a-zA-Z0-9\/]+$/")]
    private ?string $slug = null;

}

