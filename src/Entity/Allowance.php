<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AllowanceRepository")
 * @ORM\Table(name="tbl_allowances")
 */
class Allowance
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="allowances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $allowance_per_night;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $allowance_per_day;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Level", inversedBy="allowance")
     */
    private $level;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getAllowancePerNight(): ?string
    {
        return $this->allowance_per_night;
    }

    public function setAllowancePerNight(string $allowance_per_night): self
    {
        $this->allowance_per_night = $allowance_per_night;

        return $this;
    }

    public function getAllowancePerDay(): ?string
    {
        return $this->allowance_per_day;
    }

    public function setAllowancePerDay(string $allowance_per_day): self
    {
        $this->allowance_per_day = $allowance_per_day;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): self
    {
        $this->level = $level;

        return $this;
    }
}
