<?php

namespace App\Entity;

use App\Repository\MeetingsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MeetingsRepository::class)]
class Meetings
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $meeting_name = null;

    #[ORM\Column(length: 255)]
    private ?string $meeting_official_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $year = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_start = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Circuits $circuit = null;

    /**
     * @var Collection<int, Sessions>
     */
    #[ORM\OneToMany(targetEntity: Sessions::class, mappedBy: 'meetings', orphanRemoval: true)]
    private Collection $sessions;

    #[ORM\ManyToOne(inversedBy: 'meetings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Schedules $schedules = null;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeetingName(): ?string
    {
        return $this->meeting_name;
    }

    public function setMeetingName(string $meeting_name): static
    {
        $this->meeting_name = $meeting_name;

        return $this;
    }

    public function getMeetingOfficialName(): ?string
    {
        return $this->meeting_official_name;
    }

    public function setMeetingOfficialName(string $meeting_official_name): static
    {
        $this->meeting_official_name = $meeting_official_name;

        return $this;
    }

    public function getYear(): ?\DateTimeInterface
    {
        return $this->year;
    }

    public function setYear(\DateTimeInterface $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->date_start;
    }

    public function setDateStart(\DateTimeInterface $date_start): static
    {
        $this->date_start = $date_start;

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
            $session->setMeetings($this);
        }

        return $this;
    }

    public function removeSession(Sessions $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getMeetings() === $this) {
                $session->setMeetings(null);
            }
        }

        return $this;
    }

    public function getSchedules(): ?Schedules
    {
        return $this->schedules;
    }

    public function setSchedules(?Schedules $schedules): static
    {
        $this->schedules = $schedules;

        return $this;
    }
}
