<?php

namespace App\Entity;

use App\Repository\SeasonsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeasonsRepository::class)]
class Seasons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Standings>
     */
    #[ORM\OneToMany(targetEntity: Standings::class, mappedBy: 'season')]
    private Collection $standings;

    #[ORM\Column]
    private ?int $year = null;

    /**
     * @var Collection<int, Races>
     */
    #[ORM\OneToMany(targetEntity: Races::class, mappedBy: 'season', orphanRemoval: true)]
    private Collection $meetings;

    public function __construct()
    {
        $this->standings = new ArrayCollection();
        $this->meetings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Standings>
     */
    public function getStandings(): Collection
    {
        return $this->standings;
    }

    public function addStanding(Standings $standing): static
    {
        if (!$this->standings->contains($standing)) {
            $this->standings->add($standing);
            $standing->setSeason($this);
        }

        return $this;
    }

    public function removeStanding(Standings $standing): static
    {
        if ($this->standings->removeElement($standing)) {
            // set the owning side to null (unless already changed)
            if ($standing->getSeason() === $this) {
                $standing->setSeason(null);
            }
        }

        return $this;
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
}
