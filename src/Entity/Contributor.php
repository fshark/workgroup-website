<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributorRepository")
 */
class Contributor
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=false)
     */
    private $role;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Production")
     * @ORM\JoinColumn(nullable=false)
     */
    private $production;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): Member
    {
        return $this->member;
    }

    public function setMember(Member $Member): self
    {
        $this->member = $Member;

        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $Role): self
    {
        $this->role = $Role;

        return $this;
    }

    public function getProduction(): Production
    {
        return $this->production;
    }

    public function setProduction(Production $Production): self
    {
        $this->production = $Production;

        return $this;
    }
}
