<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 * @ORM\Table(name="zones")
 */
class Zone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="zone")
     */
    private $location;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Allowance", mappedBy="zone")
     */
    private $allowances;

    public function __construct()
    {
        $this->location = new ArrayCollection();
        $this->allowances = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getZone(): ?string
    {
        return $this->zone;
    }

    public function setZone(string $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocation(): Collection
    {
        return $this->location;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->location->contains($location)) {
            $this->location[] = $location;
            $location->setZone($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->location->contains($location)) {
            $this->location->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getZone() === $this) {
                $location->setZone(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return (String)$this->zone;
    }

    /**
     * @return Collection|Allowance[]
     */
    public function getAllowances(): Collection
    {
        return $this->allowances;
    }

    public function addAllowance(Allowance $allowance): self
    {
        if (!$this->allowances->contains($allowance)) {
            $this->allowances[] = $allowance;
            $allowance->setZone($this);
        }

        return $this;
    }

    public function removeAllowance(Allowance $allowance): self
    {
        if ($this->allowances->contains($allowance)) {
            $this->allowances->removeElement($allowance);
            // set the owning side to null (unless already changed)
            if ($allowance->getZone() === $this) {
                $allowance->setZone(null);
            }
        }

        return $this;
    }
}
