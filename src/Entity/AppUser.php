<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AppUserRepository")
 * @ORM\Table(name="tbl_appusers")
 * @UniqueEntity(
 * fields ={"email"},
 * message ="Email exits in the system!")
 */
class AppUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     *  @Assert\Email()
     */
    private $email;
     /**
     * @ORM\Column(type="string", length=16)
     * @Assert\Length(min=4,minMessage="The minimum password characters must be at least 4.")
     */
    private $password;

   /**
    *  @Assert\EqualTo(propertyPath="password",message="The password is not mutch!")
    */
    public $confirm_password;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Authoriser", inversedBy="appUsers")
     */
    private $role;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRole(): ?Authoriser
    {
        return $this->role;
    }

    public function setRole(?Authoriser $role): self
    {
        $this->role = $role;

        return $this;
    }

}
