<?php

namespace App\Entity;

use App\Repository\SeasonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SeasonsRepository::class)]
class Seasons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['seasons.index', 'seasons.show'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['seasons.index', 'seasons.show'])]
    private ?int $year = null;

    /**
     * @var Collection<int, Races>
     */
    #[Groups(['seasons.show'])]
    #[ORM\OneToMany(targetEntity: Races::class, mappedBy: 'season', orphanRemoval: true)]
    private Collection $meetings;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['seasons.show'])]
    private ?Standings $driverStandings = null;


    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['seasons.show'])]
    private ?Standings $constructorStandings = null;

    public function __construct()
    {
        $this->standings = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @return Collection<int, Races>
     */
    public function getMeetings(): Collection
    {
        return $this->meetings;
    }

    public function addMeeting(Races $meeting): static
    {
        if (!$this->meetings->contains($meeting)) {
            $this->meetings->add($meeting);
            $meeting->setSeason($this);
        }

        return $this;
    }

    public function removeMeeting(Races $meeting): static
    {
        if ($this->meetings->removeElement($meeting)) {
            // set the owning side to null (unless already changed)
            if ($meeting->getSeason() === $this) {
                $meeting->setSeason(null);
            }
        }

        return $this;
    }

    public function getDriverStandings(): ?Standings
    {
        return $this->driverStandings;
    }

    public function setDriverStandings(?Standings $driverStandings): static
    {
        $this->driverStandings = $driverStandings;

        return $this;
    }

    public function getConstructorStandings(): ?Standings
    {
        return $this->constructorStandings;
    }

    public function setConstructorStandings(?Standings $constructorStandings): static
    {
        $this->constructorStandings = $constructorStandings;

        return $this;
    }
}
