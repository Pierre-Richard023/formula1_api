<?php

namespace App\Entity;

use App\Repository\EntrantsDriversRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Attribute\SerializedName;

#[ORM\Entity(repositoryClass: EntrantsDriversRepository::class)]
class EntrantsDrivers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['drivers.career'])]
    private ?Drivers $drivers = null;

    /**
     * @var Collection<int, Entrants>
     */
    #[ORM\OneToMany(targetEntity: Entrants::class, mappedBy: 'entrantsDrivers')]
    #[Groups(['drivers.career'])]
    #[SerializedName('career')]
    private Collection $entrants;

    public function __construct()
    {
        $this->entrants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDrivers(): ?Drivers
    {
        return $this->drivers;
    }

    public function setDrivers(?Drivers $drivers): static
    {
        $this->drivers = $drivers;

        return $this;
    }

    /**
     * @return Collection<int, Entrants>
     */
    public function getEntrants(): Collection
    {
        return $this->entrants;
    }

    public function addEntrant(Entrants $entrant): static
    {
        if (!$this->entrants->contains($entrant)) {
            $this->entrants->add($entrant);
            $entrant->setEntrantsDrivers($this);
        }

        return $this;
    }

    public function removeEntrant(Entrants $entrant): static
    {
        if ($this->entrants->removeElement($entrant)) {
            // set the owning side to null (unless already changed)
            if ($entrant->getEntrantsDrivers() === $this) {
                $entrant->setEntrantsDrivers(null);
            }
        }

        return $this;
    }
}
