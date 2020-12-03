<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductionRepository")
 */
class Production
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $year;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Play", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $play;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Contributor", mappedBy="production")
     */
    private $contributors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="production")
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="production", orphanRemoval=true)
     */
    private $events;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Image", cascade={"persist", "remove"})
     */
    private $main_image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_visible;

    public function __construct()
    {
        $this->contributors = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;

        return $this;
    }

    public function getPlay(): Play
    {
        return $this->play;
    }

    public function setPlay(Play $play): self
    {
        $this->play = $play;

        return $this;
    }

    /**
     * @return Collection|Contributor[]
     */
    public function getContributors(): Collection
    {
        return $this->contributors;
    }

    public function addContributor(Contributor $contributor): self
    {
        if (!$this->contributors->contains($contributor)) {
            $this->contributors[] = $contributor;
        }

        return $this;
    }

    public function removeContributor(Contributor $contributor): self
    {
        if ($this->contributors->contains($contributor)) {
            $this->contributors->removeElement($contributor);
        }

        return $this;
    }

    /**
     * @return Collection|Image[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduction($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            // set the owning side to null (unless already changed)
            if ($image->getProduction() === $this) {
                $image->setProduction(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Event[]
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->setProduction($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): self
    {
        if ($this->events->contains($event)) {
            $this->events->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getProduction() === $this) {
                $event->setProduction(null);
            }
        }

        return $this;
    }

    /**
     * returns true if at least one event can be booked
     * @return bool
     */
    public function isBookable(): bool
    {
        if (empty($this->getEvents())) {
            return false;
        }

        foreach ($this->getEvents() as $event) {
            if ($event->canBeBooked()) {
                return true;
            }
        }

        return false;
    }

    public function getMainImage(): ?Image
    {
        return $this->main_image;
    }

    public function setMainImage(?Image $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->is_visible;
    }

    public function setIsVisible(bool $is_visible): self
    {
        $this->is_visible = $is_visible;

        return $this;
    }
}
