<?php

namespace App\Entity;

use App\Repository\StandingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StandingsRepository::class)]
class Standings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, StandingEntry>
     */
    #[ORM\OneToMany(targetEntity: StandingEntry::class, mappedBy: 'standings', orphanRemoval: true)]
    private Collection $entries;

    #[ORM\ManyToOne(inversedBy: 'standings')]
    private ?Seasons $season = null;

    public function __construct()
    {
        $this->entries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, StandingEntry>
     */
    public function getEntries(): Collection
    {
        return $this->entries;
    }

    public function addEntry(StandingEntry $entry): static
    {
        if (!$this->entries->contains($entry)) {
            $this->entries->add($entry);
            $entry->setStandings($this);
        }

        return $this;
    }

    public function removeEntry(StandingEntry $entry): static
    {
        if ($this->entries->removeElement($entry)) {
            // set the owning side to null (unless already changed)
            if ($entry->getStandings() === $this) {
                $entry->setStandings(null);
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
}
