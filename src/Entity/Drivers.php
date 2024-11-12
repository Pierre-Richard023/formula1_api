<?php

namespace App\Entity;

use App\Repository\DriversRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: DriversRepository::class)]
class Drivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['drivers.search', 'drivers.show', "races.show"])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['drivers.search', 'drivers.show'])]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    #[Groups(['drivers.search', 'drivers.show'])]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['drivers.show', 'races.show'])]
    #[SerializedName('name')]
    private ?string $full_name = null;

    #[ORM\Column(length: 5)]
    #[Groups(['drivers.search', 'drivers.show'])]
    private ?string $abbreviation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['drivers.search', 'drivers.show'])]
    private ?string $country = null;

    #[ORM\Column]
    #[Groups(['drivers.show'])]
    private ?int $world_championships = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Groups(['drivers.show'])]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(length: 255)]
    #[Groups(['drivers.search', 'drivers.show'])]
    private ?string $place_of_birth = null;

    #[ORM\Column]
    #[Groups(['drivers.show'])]
    private ?int $podiums = null;

    #[ORM\Column]
    #[Groups(['drivers.show'])]
    private ?int $grands_prix_entered = null;

    #[ORM\Column]
    #[Groups(['drivers.show'])]
    private ?int $race_wins = null;

    #[ORM\Column]
    #[Groups(['drivers.show'])]
    private ?int $pole_positions = null;

    #[ORM\Column(length: 255)]
    #[Groups(['drivers.show'])]
    private ?string $nationality = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['drivers.show'])]
    private ?\DateTimeInterface $date_of_death = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['drivers.search', 'drivers.show', 'races.show'])]
    #[SerializedName('number')]
    private ?int $permanent_number = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

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

    public function getAbbreviation(): ?string
    {
        return $this->abbreviation;
    }

    public function setAbbreviation(string $abbreviation): static
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $Country): static
    {
        $this->country = $Country;

        return $this;
    }

    public function getWorldChampionships(): ?int
    {
        return $this->world_championships;
    }

    public function setWorldChampionships(int $world_championships): static
    {
        $this->world_championships = $world_championships;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): static
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getPlaceOfBirth(): ?string
    {
        return $this->place_of_birth;
    }

    public function setPlaceOfBirth(string $place_of_birth): static
    {
        $this->place_of_birth = $place_of_birth;

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

    public function getGrandsPrixEntered(): ?int
    {
        return $this->grands_prix_entered;
    }

    public function setGrandsPrixEntered(int $grands_prix_entered): static
    {
        $this->grands_prix_entered = $grands_prix_entered;

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

    public function getPolePositions(): ?int
    {
        return $this->pole_positions;
    }

    public function setPolePositions(int $pole_positions): static
    {
        $this->pole_positions = $pole_positions;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): static
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function getDateOfDeath(): ?\DateTimeInterface
    {
        return $this->date_of_death;
    }

    public function setDateOfDeath(?\DateTimeInterface $date_of_death): static
    {
        $this->date_of_death = $date_of_death;

        return $this;
    }

    public function getPermanentNumber(): ?int
    {
        return $this->permanent_number;
    }

    public function setPermanentNumber(?int $permanent_number): static
    {
        $this->permanent_number = $permanent_number;

        return $this;
    }
}
