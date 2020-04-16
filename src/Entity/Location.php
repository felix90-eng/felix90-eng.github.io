<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 *  @ORM\Table(name="locations")
 */
class Location
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
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="location")
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="destination1")
     */
    private $mission;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="loc4Hosted")
     */
    private $missions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="loc2Hosted")
     */
    private $missiyo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Mission", mappedBy="destinaion4")
     */
    private $missio;

    public function __construct()
    {
        $this->missions = new ArrayCollection();
        $this->missiyo = new ArrayCollection();
        $this->missio = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
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

    public function __toString(){
        return (String)$this->location;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissions(): Collection
    {
        return $this->missions;
    }

    public function addMission(Mission $mission): self
    {
        if (!$this->missions->contains($mission)) {
            $this->missions[] = $mission;
            $mission->setDestination1($this);
        }

        return $this;
    }

    public function removeMission(Mission $mission): self
    {
        if ($this->missions->contains($mission)) {
            $this->missions->removeElement($mission);
            // set the owning side to null (unless already changed)
            if ($mission->getDestination1() === $this) {
                $mission->setDestination1(null);
            }
        }

        return $this;
    }

    public function getMission(): ?Mission
    {
        return $this->mission;
    }

    public function setMission(?Mission $mission): self
    {
        $this->mission = $mission;

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissiyo(): Collection
    {
        return $this->missiyo;
    }

    public function addMissiyo(Mission $missiyo): self
    {
        if (!$this->missiyo->contains($missiyo)) {
            $this->missiyo[] = $missiyo;
            $missiyo->setLoc2Hosted($this);
        }

        return $this;
    }

    public function removeMissiyo(Mission $missiyo): self
    {
        if ($this->missiyo->contains($missiyo)) {
            $this->missiyo->removeElement($missiyo);
            // set the owning side to null (unless already changed)
            if ($missiyo->getLoc2Hosted() === $this) {
                $missiyo->setLoc2Hosted(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Mission[]
     */
    public function getMissio(): Collection
    {
        return $this->missio;
    }

    public function addMissio(Mission $missio): self
    {
        if (!$this->missio->contains($missio)) {
            $this->missio[] = $missio;
            $missio->setDestinaion4($this);
        }

        return $this;
    }

    public function removeMissio(Mission $missio): self
    {
        if ($this->missio->contains($missio)) {
            $this->missio->removeElement($missio);
            // set the owning side to null (unless already changed)
            if ($missio->getDestinaion4() === $this) {
                $missio->setDestinaion4(null);
            }
        }

        return $this;
    }
}
