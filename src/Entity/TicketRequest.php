<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketRequestRepository")
 */
class TicketRequest
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
    private $amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emailaddress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phonenumber;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Event", inversedBy="ticketRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $event;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailaddress(): ?string
    {
        return $this->emailaddress;
    }

    /**
     * @param string $emailaddress
     * @return self
     */
    public function setEmailaddress($emailaddress): self
    {
        $this->emailaddress = $emailaddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhonenumber(): ?string
    {
        return $this->phonenumber;
    }

    /**
     * @param string $phonenumber
     * @return self
     */
    public function setPhonenumber($phonenumber): self
    {
        $this->phonenumber = $phonenumber;

        return $this;
    }

    public static function createDefault(): TicketRequest
    {
        $result = new self();
        $result->setAmount(2);

        return $result;
    }

    public function __toString(): string
    {
        return 'Kartenanfrage: '.$this->getEvent().PHP_EOL .
            'Anzahl: '.$this->getAmount().PHP_EOL .
            'Name: '.$this->getFirstname(). ' '.$this->getLastname().PHP_EOL .
            'Email-Adresse: '.$this->getEmailaddress().PHP_EOL .
            'Telefonnummer: '.$this->getPhonenumber();
    }
}
