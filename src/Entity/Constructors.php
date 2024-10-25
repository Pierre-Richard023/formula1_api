<?php

namespace App\Entity;

use App\Repository\ConstructorsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConstructorsRepository::class)]
class Constructors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(length: 255)]
    private ?string $base = null;

    #[ORM\Column(length: 255)]
    private ?string $team_chief = null;

    #[ORM\Column(length: 255)]
    private ?string $technical_chief = null;

    #[ORM\Column(length: 255)]
    private ?string $power_unit = null;

    #[ORM\Column]
    private ?int $wolrd_championships = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $team_entry = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->full_name;
    }

    public function setFullName(string $full_name): static
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function getBase(): ?string
    {
        return $this->base;
    }

    public function setBase(string $base): static
    {
        $this->base = $base;

        return $this;
    }

    public function getTeamChief(): ?string
    {
        return $this->team_chief;
    }

    public function setTeamChief(string $team_chief): static
    {
        $this->team_chief = $team_chief;

        return $this;
    }

    public function getTechnicalChief(): ?string
    {
        return $this->technical_chief;
    }

    public function setTechnicalChief(string $technical_chief): static
    {
        $this->technical_chief = $technical_chief;

        return $this;
    }

    public function getPowerUnit(): ?string
    {
        return $this->power_unit;
    }

    public function setPowerUnit(string $power_unit): static
    {
        $this->power_unit = $power_unit;

        return $this;
    }

    public function getWolrdChampionships(): ?int
    {
        return $this->wolrd_championships;
    }

    public function setWolrdChampionships(int $wolrd_championships): static
    {
        $this->wolrd_championships = $wolrd_championships;

        return $this;
    }

    public function getTeamEntry(): ?\DateTimeInterface
    {
        return $this->team_entry;
    }

    public function setTeamEntry(\DateTimeInterface $team_entry): static
    {
        $this->team_entry = $team_entry;

        return $this;
    }
}
