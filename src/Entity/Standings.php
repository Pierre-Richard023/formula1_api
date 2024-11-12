<?php

namespace App\Entity;

use App\Repository\StandingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    #[Groups(['races.show',"seasons.show.standing.driver"])]
    #[ORM\OneToMany(targetEntity: StandingEntry::class, mappedBy: 'standings', orphanRemoval: true)]
    private Collection $entries;

    #[ORM\OneToOne(mappedBy: 'standing', cascade: ['persist', 'remove'])]
    private ?Sessions $session = null;

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


    public function getSession(): ?Sessions
    {
        return $this->session;
    }

    public function setSession(?Sessions $sessions): static
    {
        // unset the owning side of the relation if necessary
        if ($sessions === null && $this->session !== null) {
            $this->session->setStanding(null);
        }

        // set the owning side of the relation if necessary
        if ($sessions !== null && $sessions->getStanding() !== $this) {
            $sessions->setStanding($this);
        }

        $this->session = $sessions;

        return $this;
    }
}
