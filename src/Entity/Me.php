<?php

namespace App\Entity;

use App\Repository\MeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeRepository::class)]
class Me
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $intro = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $intro_fr = null;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(?string $intro): static
    {
        $this->intro = $intro;

        return $this;
    }

    public function getIntroFr(): ?string
    {
        return $this->intro_fr;
    }

    public function setIntroFr(?string $intro_fr): static
    {
        $this->intro_fr = $intro_fr;

        return $this;
    }
}
