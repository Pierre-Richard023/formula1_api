<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $countryId = null;

    #[ORM\Column(length: 255)]
    #[SerializedName("country")]
    private ?string $name = null;

    #[ORM\Column(length: 255,nullable:  true)]
    private ?string $demonym = null;

    #[ORM\Column(length: 255)]
    private ?string $continent = null;

    #[ORM\Column(length: 5)]
    private ?string $continent_code = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountryId(): ?string
    {
        return $this->countryId;
    }

    public function setCountryId(string $countryId): static
    {
        $this->countryId = $countryId;

        return $this;
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

    public function getDemonym(): ?string
    {
        return $this->demonym;
    }

    public function setDemonym(string $demonym): static
    {
        $this->demonym = $demonym;

        return $this;
    }

    public function getContinent(): ?string
    {
        return $this->continent;
    }

    public function setContinent(string $continent): static
    {
        $this->continent = $continent;

        return $this;
    }

    public function getContinentCode(): ?string
    {
        return $this->continent_code;
    }

    public function setContinentCode(string $continent_code): static
    {
        $this->continent_code = $continent_code;

        return $this;
    }
}
