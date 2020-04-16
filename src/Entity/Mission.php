<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MissionRepository")
 * @ORM\Table(name="tbl_missions")
 */
class Mission
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $mis_purpose;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mis_category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination1;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="missions")
     */
    private $destination2;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="missions")
     */
    private $destination3;

    /**
     * @ORM\Column(type="date")
     */
    private $leavedAt;

    /**
     * @ORM\Column(type="date")
     */
    private $returnedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $mean_trans;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="missions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $staff;
    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $mstatus;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Expense", mappedBy="mission")
     */
    private $allowance;
        /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $lineSupervisorChecked;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $verifiedByAccountant;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $decisionFromDG;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $paymentPreparedByAccountant;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $approvalOfDF;

    /**
     * @ORM\Column(type="string", length=30,nullable=true)
     */
    private $approvalOfCSDM;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $d1IdNumDay;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $d2IdNumDay;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $d3IdNumDay;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $d4IdNumDay;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $numDays;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Location", inversedBy="missio")
     */
    private $destination4;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tallowance;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Vehicle", mappedBy="mission")
     */
    private $vehicles;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="missions")
     */
    private $department;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="missions")
     */
    private $position;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Supervisor", inversedBy="missions")
     */
    private $supervisor;

    /**
     * @ORM\Column(type="string", length=40, nullable=true)
     */
    private $actiontakenBy;

    public function __construct()
    {
        $this->allowance = new ArrayCollection();
        $this->vehicles = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMisPurpose(): ?string
    {
        return $this->mis_purpose;
    }

    public function setMisPurpose(string $mis_purpose): self
    {
        $this->mis_purpose = $mis_purpose;

        return $this;
    }

    public function getMisCategory(): ?string
    {
        return $this->mis_category;
    }

    public function setMisCategory(string $mis_category): self
    {
        $this->mis_category = $mis_category;

        return $this;
    }

    public function getDestination1(): ?Location
    {
        return $this->destination1;
    }

    public function setDestination1(?Location $destination1): self
    {
        $this->destination1 = $destination1;

        return $this;
    }

    public function getDestination2(): ?Location
    {
        return $this->destination2;
    }

    public function setDestination2(?Location $destination2): self
    {
        $this->destination2 = $destination2;

        return $this;
    }

    public function getDestination3(): ?Location
    {
        return $this->destination3;
    }

    public function setDestination3(?Location $destination3): self
    {
        $this->destination3 = $destination3;

        return $this;
    }

    public function getLeavedAt(): ?\DateTimeInterface
    {
        return $this->leavedAt;
    }

    public function setLeavedAt(\DateTimeInterface $leavedAt): self
    {
        $this->leavedAt = $leavedAt;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeInterface
    {
        return $this->returnedAt;
    }

    public function setReturnedAt(\DateTimeInterface $returnedAt): self
    {
        $this->returnedAt = $returnedAt;

        return $this;
    }

    public function getMeanTrans(): ?string
    {
        return $this->mean_trans;
    }

    public function setMeanTrans(?string $mean_trans): self
    {
        $this->mean_trans = $mean_trans;

        return $this;
    }

    public function getStaff(): ?Staff
    {
        return $this->staff;
    }

    public function setStaff(?Staff $staff): self
    {
        $this->staff = $staff;

        return $this;
    }

    public function getMstatus(): ?string
    {
        return $this->mstatus;
    }

    public function setMstatus(?string $mstatus): self
    {
        $this->mstatus = $mstatus;

        return $this;
    }

    /**
     * @return Collection|Expense[]
     */
    public function getAllowance(): Collection
    {
        return $this->allowance;
    }

    public function addAllowance(Expense $allowance): self
    {
        if (!$this->allowance->contains($allowance)) {
            $this->allowance[] = $allowance;
            $allowance->setMission($this);
        }

        return $this;
    }

    public function removeAllowance(Expense $allowance): self
    {
        if ($this->allowance->contains($allowance)) {
            $this->allowance->removeElement($allowance);
            // set the owning side to null (unless already changed)
            if ($allowance->getMission() === $this) {
                $allowance->setMission(null);
            }
        }

        return $this;
    }
    public function getLineSupervisorChecked(): ?string
    {
        return $this->lineSupervisorChecked;
    }

    public function setLineSupervisorChecked(?string $lineSupervisorChecked): self
    {
        $this->lineSupervisorChecked = $lineSupervisorChecked;

        return $this;
    }

    public function getVerifiedByAccountant(): ?string
    {
        return $this->verifiedByAccountant;
    }

    public function setVerifiedByAccountant(?string $verifiedByAccountant): self
    {
        $this->verifiedByAccountant = $verifiedByAccountant;

        return $this;
    }

    public function getDecisionFromDG(): ?string
    {
        return $this->decisionFromDG;
    }

    public function setDecisionFromDG(?string $decisionFromDG): self
    {
        $this->decisionFromDG = $decisionFromDG;

        return $this;
    }

    public function getPaymentPreparedByAccountant(): ?string
    {
        return $this->paymentPreparedByAccountant;
    }

    public function setPaymentPreparedByAccountant(?string $paymentPreparedByAccountant): self
    {
        $this->paymentPreparedByAccountant = $paymentPreparedByAccountant;

        return $this;
    }

    public function getApprovalOfDF(): ?string
    {
        return $this->approvalOfDF;
    }

    public function setApprovalOfDF(?string $approvalOfDF): self
    {
        $this->approvalOfDF = $approvalOfDF;

        return $this;
    }

    public function getApprovalOfCSDM(): ?string
    {
        return $this->approvalOfCSDM;
    }

    public function setApprovalOfCSDM(string $approvalOfCSDM): self
    {
        $this->approvalOfCSDM = $approvalOfCSDM;

        return $this;
    }

    public function getD1IdNumDay(): ?string
    {
        return $this->d1IdNumDay;
    }

    public function setD1IdNumDay(?string $d1IdNumDay): self
    {
        $this->d1IdNumDay = $d1IdNumDay;

        return $this;
    }

    public function getD2IdNumDay(): ?string
    {
        return $this->d2IdNumDay;
    }

    public function setD2IdNumDay(?string $d2IdNumDay): self
    {
        $this->d2IdNumDay = $d2IdNumDay;

        return $this;
    }

    public function getD3IdNumDay(): ?string
    {
        return $this->d3IdNumDay;
    }

    public function setD3IdNumDay(?string $d3IdNumDay): self
    {
        $this->d3IdNumDay = $d3IdNumDay;

        return $this;
    }

    public function getD4IdNumDay(): ?string
    {
        return $this->d4IdNumDay;
    }

    public function setD4IdNumDay(?string $d4IdNumDay): self
    {
        $this->d4IdNumDay = $d4IdNumDay;

        return $this;
    }

    public function getNumDays(): ?string
    {
        return $this->numDays;
    }

    public function setNumDays(?string $numDays): self
    {
        $this->numDays = $numDays;

        return $this;
    }

    public function getDestination4(): ?Location
    {
        return $this->destination4;
    }

    public function setDestination4(?Location $destination4): self
    {
        $this->destination4 = $destination4;

        return $this;
    }

    public function getDestinaion4(): ?Location
    {
        return $this->destinaion4;
    }

    public function setDestinaion4(?Location $destinaion4): self
    {
        $this->destinaion4 = $destinaion4;

        return $this;
    }

    public function getTallowance(): ?string
    {
        return $this->tallowance;
    }

    public function setTallowance(?string $tallowance): self
    {
        $this->tallowance = $tallowance;

        return $this;
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setMission($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getMission() === $this) {
                $vehicle->setMission(null);
            }
        }

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getSupervisor(): ?Supervisor
    {
        return $this->supervisor;
    }

    public function setSupervisor(?Supervisor $supervisor): self
    {
        $this->supervisor = $supervisor;

        return $this;
    }

    public function getActiontakenBy(): ?string
    {
        return $this->actiontakenBy;
    }

    public function setActiontakenBy(?string $actiontakenBy): self
    {
        $this->actiontakenBy = $actiontakenBy;

        return $this;
    }


}
