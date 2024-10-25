<?php

namespace App\Entity;

use App\Repository\DriversRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DriversRepository::class)]
class Drivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $first_name = null;

    #[ORM\Column(length: 100)]
    private ?string $last_name = null;

    #[ORM\Column(length: 255)]
    private ?string $full_name = null;

    #[ORM\Column(length: 5)]
    private ?string $name_acronym = null;

    #[ORM\Column(length: 5)]
    private ?string $country_code = null;

    #[ORM\Column(length: 255)]
    private ?string $Country = null;

    #[ORM\Column]
    private ?int $world_championships = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(length: 255)]
    private ?string $place_of_birth = null;

    #[ORM\Column]
    private ?int $podiums = null;

    #[ORM\Column]
    private ?int $grands_prix_entered = null;

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

    public function getNameAcronym(): ?string
    {
        return $this->name_acronym;
    }

    public function setNameAcronym(string $name_acronym): static
    {
        $this->name_acronym = $name_acronym;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): static
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->Country;
    }

    public function setCountry(string $Country): static
    {
        $this->Country = $Country;

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
}
