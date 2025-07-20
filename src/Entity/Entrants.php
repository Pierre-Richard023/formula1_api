<?php

namespace App\Entity;

use App\Repository\EntrantsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EntrantsRepository::class)]
class Entrants
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['drivers.career'])]
    private ?int $season = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['drivers.career'])]
    private ?Constructors $constructors = null;

    #[ORM\Column]
    #[Groups(['drivers.career'])]
    private ?bool $testDriver = null;

    #[ORM\Column(type: Types::JSON)]
    #[Groups(['drivers.career'])]
    private array $races = [];

    #[ORM\ManyToOne(inversedBy: 'entrants')]
    private ?EntrantsDrivers $entrantsDrivers = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeason(): ?int
    {
        return $this->season;
    }

    public function setSeason(int $season): static
    {
        $this->season = $season;

        return $this;
    }
    
    public function getRaces(): array
    {
        return $this->races;
    }

    public function setRaces(array $races): static
    {
        $this->races = $races;

        return $this;
    }

    public function isTestDriver(): ?bool
    {
        return $this->testDriver;
    }

    public function setTestDriver(bool $testDriver): static
    {
        $this->testDriver = $testDriver;

        return $this;
    }

    public function getEntrantsDrivers(): ?EntrantsDrivers
    {
        return $this->entrantsDrivers;
    }

    public function setEntrantsDrivers(?EntrantsDrivers $entrantsDrivers): static
    {
        $this->entrantsDrivers = $entrantsDrivers;

        return $this;
    }

    public function getConstructors(): ?Constructors
    {
        return $this->constructors;
    }

    public function setConstructors(?Constructors $constructors): static
    {
        $this->constructors = $constructors;

        return $this;
    }
}
