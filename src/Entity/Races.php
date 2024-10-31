<?php

namespace App\Entity;

use App\Repository\RacesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RacesRepository::class)]
class Races
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $official_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $raceDate = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Circuits $circuit = null;

    /**
     * @var Collection<int, Sessions>
     */
    #[ORM\OneToMany(targetEntity: Sessions::class, mappedBy: 'race', orphanRemoval: true)]
    private Collection $sessions;

    #[ORM\ManyToOne(inversedBy: 'meetings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seasons $season = null;

    #[ORM\Column]
    private ?int $laps = null;

    #[ORM\Column]
    private ?float $distance = null;

    #[ORM\Column(length: 100)]
    private ?string $qualifyingFormat = null;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

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

    public function getOfficialName(): ?string
    {
        return $this->official_name;
    }

    public function setOfficialName(string $official_name): static
    {
        $this->official_name = $official_name;

        return $this;
    }

    public function getRaceDate(): ?\DateTimeInterface
    {
        return $this->raceDate;
    }

    public function setRaceDate(\DateTimeInterface $raceDate): static
    {
        $this->raceDate = $raceDate;

        return $this;
    }

    public function getCircuit(): ?Circuits
    {
        return $this->circuit;
    }

    public function setCircuit(?Circuits $circuit): static
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * @return Collection<int, Sessions>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Sessions $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setRace($this);
        }

        return $this;
    }

    public function removeSession(Sessions $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getRace() === $this) {
                $session->setRace(null);
            }
        }

        return $this;
    }

    public function getSeason(): ?Seasons
    {
        return $this->season;
    }

    public function setSeason(?Seasons $season): static
    {
        $this->season = $season;

        return $this;
    }

    public function getLaps(): ?int
    {
        return $this->laps;
    }

    public function setLaps(int $laps): static
    {
        $this->laps = $laps;

        return $this;
    }

    public function getDistance(): ?float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): static
    {
        $this->distance = $distance;

        return $this;
    }

    public function getQualifyingFormat(): ?string
    {
        return $this->qualifyingFormat;
    }

    public function setQualifyingFormat(string $qualifyingFormat): static
    {
        $this->qualifyingFormat = $qualifyingFormat;

        return $this;
    }

}
