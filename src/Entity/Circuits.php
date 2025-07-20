<?php

namespace App\Entity;

use App\Repository\CircuitsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CircuitsRepository::class)]
class Circuits
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['seasons.show', 'races.show', 'races.search', 'circuits.search', 'circuits.show'])]
    private ?string $circuitsId = null;
    #[ORM\Column(length: 255)]
    #[Groups(['seasons.show', 'races.show', 'races.search', 'circuits.search', 'circuits.show'])]
    private ?string $name = null;
    
    #[ORM\Column(length: 100)]
    #[Groups(['races.show', 'races.search', 'circuits.search', 'circuits.show'])]
    private ?string $short_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['circuits.show'])]
    private ?string $location = null;

    #[ORM\Column(length: 20)]
    #[Groups(['circuits.show'])]
    private ?string $type = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['seasons.show', 'races.show', 'races.search', 'circuits.search', 'circuits.show'])]
    private ?Country $country = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCircuitsId(): ?string
    {
        return $this->circuitsId;
    }

    public function setCircuitsId(string $circuitsId): static
    {
        $this->circuitsId = $circuitsId;

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

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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
