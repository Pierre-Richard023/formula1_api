<?php

namespace App\Entity;

use App\Repository\SessionsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionsRepository::class)]
class Sessions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Races $race = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Standings $standing = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRace(): ?Races
    {
        return $this->race;
    }

    public function setRace(?Races $race): static
    {
        $this->race = $race;

        return $this;
    }

    public function getStanding(): ?Standings
    {
        return $this->standing;
    }

    public function setStanding(?Standings $standing): static
    {
        $this->standing = $standing;

        return $this;
    }
}
