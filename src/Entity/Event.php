<?php

namespace App\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $datetime;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="smallint")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\TicketRequest", mappedBy="event", orphanRemoval=true)
     */
    private $ticketRequests;

    /**
     * @ORM\Column(type="smallint")
     */
    private $maximumContingent;

    /**
     * @ORM\Column(type="smallint")
     */
    private $contingent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isBookable;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Production", inversedBy="events")
     * @ORM\JoinColumn(nullable=false)
     */
    private $production;

    public function __construct()
    {
        $this->ticketRequests = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): \DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|TicketRequest[]
     */
    public function getTicketRequests(): Collection
    {
        return $this->ticketRequests;
    }

    public function addTicketRequest(TicketRequest $ticketRequest): self
    {
        if (!$this->ticketRequests->contains($ticketRequest)) {
            $this->ticketRequests[] = $ticketRequest;
            $ticketRequest->setEvent($this);
        }

        return $this;
    }

    public function removeTicketRequest(TicketRequest $ticketRequest): self
    {
        if ($this->ticketRequests->contains($ticketRequest)) {
            $this->ticketRequests->removeElement($ticketRequest);
            // set the owning side to null (unless already changed)
            if ($ticketRequest->getEvent() === $this) {
                $ticketRequest->setEvent(null);
            }
        }

        return $this;
    }

    public function getMaximumContingent(): ?int
    {
        return $this->maximumContingent;
    }

    public function setMaximumContingent(int $maximumContingent): self
    {
        $this->maximumContingent = $maximumContingent;

        return $this;
    }

    public function getContingent(): ?int
    {
        return $this->contingent;
    }

    public function setContingent(int $contingent): self
    {
        $this->contingent = $contingent;

        return $this;
    }

    public function getIsBookable(): ?bool
    {
        return $this->isBookable;
    }

    public function setIsBookable(bool $isBookable): self
    {
        $this->isBookable = $isBookable;

        return $this;
    }

    public function getProduction(): Production
    {
        return $this->production;
    }

    public function setProduction(?Production $production): self
    {
        $this->production = $production;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf(
            '%s - %s: "%s" (EUR %d,-)',
            $this->getFormattedDate(),
            $this->getTitle(),
            $this->getProduction()->getPlay()->getTitle(),
            $this->getPrice()
        );
    }

    public function getFormattedDate(): string
    {
        return $this->getFormattedWeekday().', '.$this->datetime->format('d.m.Y, H:i'). ' Uhr';
    }

    public function getFormattedWeekday(): string
    {
        switch ($this->datetime->format('w')) {
            case 0: $result = 'Sonntag'; break;
            case 1: $result = 'Montag'; break;
            case 2: $result = 'Dienstag'; break;
            case 3: $result = 'Mittwoch'; break;
            case 4: $result = 'Donnerstag'; break;
            case 5: $result = 'Freitag'; break;
            case 6: $result = 'Samstag'; break;
            default: throw new \Exception('Invalid Weekday.');
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function isInFuture(): bool
    {
        return $this->getDatetime()->modify('-1 day') > new DateTime();
    }

    /**
     * @return bool
     */
    public function hasContingent(): bool
    {
        return $this->getContingent() > 0;
    }

    /**
     * @return bool
     */
    public function canBeBooked(): bool
    {
        return $this->getIsBookable() && $this->isInFuture() && $this->hasContingent();
    }
}
