<?php

namespace App\Entity;

use App\Repository\ConstructorsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ConstructorsRepository::class)]
class Constructors
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['constructors.search', 'constructors.show','drivers.career'])]
    private ?string $constructorId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['constructors.search', 'constructors.show'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['constructors.search', 'constructors.show'])]
    private ?string $full_name = null;

    #[ORM\Column]
    #[Groups(['constructors.show'])]
    private ?int $wolrd_championships = null;

    #[ORM\Column]
    #[Groups(['constructors.show'])]
    private ?int $race_entries = null;

    #[ORM\Column]
    #[Groups(['constructors.show'])]
    private ?int $race_wins = null;

    #[ORM\Column]
    #[Groups(['constructors.show'])]
    private ?int $podiums = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['constructors.search','constructors.show'])]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getConstructorId(): ?string
    {
        return $this->constructorId;
    }

    public function setConstructorId(string $constructorId): static
    {
        $this->constructorId = $constructorId;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
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

    public function getWolrdChampionships(): ?int
    {
        return $this->wolrd_championships;
    }

    public function setWolrdChampionships(int $wolrd_championships): static
    {
        $this->wolrd_championships = $wolrd_championships;

        return $this;
    }

    public function getRaceEntries(): ?int
    {
        return $this->race_entries;
    }

    public function setRaceEntries(int $race_entries): static
    {
        $this->race_entries = $race_entries;

        return $this;
    }

    public function getRaceWins(): ?int
    {
        return $this->race_wins;
    }

    public function setRaceWins(int $race_wins): static
    {
        $this->race_wins = $race_wins;

        return $this;
    }

    public function getPodiums(): ?int
    {
        return $this->podiums;
    }

    public function setPodiums(int $podiums): static
    {
        $this->podiums = $podiums;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }
}
