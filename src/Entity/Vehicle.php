<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 * @ORM\Table(name="tbl_vehicles")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff", inversedBy="vehicles")
     */
    private $staff;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $purpose;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Position", inversedBy="vehicles")
     */
    private $position;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transportername;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $companyname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $platno;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tripamount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $tripdays;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $totalamount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $transporterstyle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ttelephone;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CarTrip", inversedBy="vehicles")
     */
    private $destination;

    /**
     * @ORM\Column(type="date")
     */
    private $timedisparture;

    /**
     * @ORM\Column(type="date")
     */
    private $arrivaltime;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $travelmode;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $travellerquantity;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    public function getId(): ?int
    {
        return $this->id;
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

   

    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    public function setPurpose(?string $purpose): self
    {
        $this->purpose = $purpose;

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

   
    public function getTransportername(): ?string
    {
        return $this->transportername;
    }

    public function setTransportername(?string $transportername): self
    {
        $this->transportername = $transportername;

        return $this;
    }

    public function getCompanyname(): ?string
    {
        return $this->companyname;
    }

    public function setCompanyname(?string $companyname): self
    {
        $this->companyname = $companyname;

        return $this;
    }

    public function getPlatno(): ?string
    {
        return $this->platno;
    }

    public function setPlatno(?string $platno): self
    {
        $this->platno = $platno;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getTripamount(): ?string
    {
        return $this->tripamount;
    }

    public function setTripamount(?string $tripamount): self
    {
        $this->tripamount = $tripamount;

        return $this;
    }

    public function getTripdays(): ?string
    {
        return $this->tripdays;
    }

    public function setTripdays(?string $tripdays): self
    {
        $this->tripdays = $tripdays;

        return $this;
    }

    public function getTotalamount(): ?string
    {
        return $this->totalamount;
    }

    public function setTotalamount(?string $totalamount): self
    {
        $this->totalamount = $totalamount;

        return $this;
    }

    public function getTransporterstyle(): ?string
    {
        return $this->transporterstyle;
    }

    public function setTransporterstyle(?string $transporterstyle): self
    {
        $this->transporterstyle = $transporterstyle;

        return $this;
    }

    public function getTtelephone(): ?string
    {
        return $this->ttelephone;
    }

    public function setTtelelephone(?string $ttelephone): self
    {
        $this->ttelelephone = $ttelephone;

        return $this;
    }

    public function getDestination(): ?CarTrip
    {
        return $this->destination;
    }

    public function setDestination(?CarTrip $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getTimedisparture(): ?\DateTimeInterface
    {
        return $this->timedisparture;
    }

    public function setTimedisparture(\DateTimeInterface $timedisparture): self
    {
        $this->timedisparture = $timedisparture;

        return $this;
    }

    public function getArrivaltime(): ?\DateTimeInterface
    {
        return $this->arrivaltime;
    }

    public function setArrivaltime(\DateTimeInterface $arrivaltime): self
    {
        $this->arrivaltime = $arrivaltime;

        return $this;
    }

    public function getTravelmode(): ?string
    {
        return $this->travelmode;
    }

    public function setTravelmode(?string $travelmode): self
    {
        $this->travelmode = $travelmode;

        return $this;
    }

    public function getTravellerquantity(): ?string
    {
        return $this->travellerquantity;
    }

    public function setTravellerquantity(?string $travellerquantity): self
    {
        $this->travellerquantity = $travellerquantity;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    
}
