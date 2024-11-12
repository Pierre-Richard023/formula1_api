<?php

namespace App\Entity;

use App\Repository\StandingEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StandingEntryRepository::class)]
class StandingEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
//    #[Groups(['races.show'])]
    private ?int $position = null;

    #[ORM\Column(nullable: true)]
//    #[Groups(['races.show'])]
    private ?float $points = null;

    #[ORM\Column(length: 50, nullable: true)]
//    #[Groups(['races.show'])]
    private ?string $raceTime = null;

    #[ORM\ManyToOne(inversedBy: 'entries')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Standings $standings = null;

    #[ORM\ManyToOne]
    #[Groups(['races.show'])]
    private ?Drivers $driver = null;

    #[ORM\ManyToOne]
    private ?Constructors $constructor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getPoints(): ?float
    {
        return $this->points;
    }

    public function setPoints(float $points): static
    {
        $this->points = $points;

        return $this;
    }

    public function getRaceTime(): ?string
    {
        return $this->raceTime;
    }

    public function setRaceTime(?string $raceTime): static
    {
        $this->raceTime = $raceTime;

        return $this;
    }

    public function getStandings(): ?Standings
    {
        return $this->standings;
    }

    public function setStandings(?Standings $standings): static
    {
        $this->standings = $standings;

        return $this;
    }

    public function getDriver(): ?Drivers
    {
        return $this->driver;
    }

    public function setDriver(?Drivers $driver): static
    {
        $this->driver = $driver;

        return $this;
    }

    public function getConstructor(): ?Constructors
    {
        return $this->constructor;
    }

    public function setConstructor(?Constructors $constructor): static
    {
        $this->constructor = $constructor;

        return $this;
    }
}
