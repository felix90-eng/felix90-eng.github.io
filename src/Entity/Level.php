<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LevelRepository")
 * @ORM\Table(name="levels")
 */
class Level
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $level;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Position", mappedBy="level")
     */
    private $position;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Allowance", mappedBy="level_for_the_post")
     */
    private $allowances;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Allowance", mappedBy="level")
     */
    private $allowance;

    public function __construct()
    {
        $this->position = new ArrayCollection();
        $this->allowances = new ArrayCollection();
        $this->allowance = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    public function setLevel(string $level): self
    {
        $this->level = $level;

        return $this;
    }

    /**
     * @return Collection|Position[]
     */
    public function getPosition(): Collection
    {
        return $this->position;
    }

    public function addPosition(Position $position): self
    {
        if (!$this->position->contains($position)) {
            $this->position[] = $position;
            $position->setLevel($this);
        }

        return $this;
    }

    public function removePosition(Position $position): self
    {
        if ($this->position->contains($position)) {
            $this->position->removeElement($position);
            // set the owning side to null (unless already changed)
            if ($position->getLevel() === $this) {
                $position->setLevel(null);
            }
        }

        return $this;
    }

    public function __toString(){
        return (String)$this->level;
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
            $allowance->setLevelForThePost($this);
        }

        return $this;
    }

    public function removeAllowance(Allowance $allowance): self
    {
        if ($this->allowances->contains($allowance)) {
            $this->allowances->removeElement($allowance);
            // set the owning side to null (unless already changed)
            if ($allowance->getLevelForThePost() === $this) {
                $allowance->setLevelForThePost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Allowance[]
     */
    public function getAllowance(): Collection
    {
        return $this->allowance;
    }
}
