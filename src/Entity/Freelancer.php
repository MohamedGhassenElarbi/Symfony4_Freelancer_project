<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FreelancerRepository")
 */
class Freelancer implements UserInterface
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
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $domaine;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mdp;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;
    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reservation", mappedBy="freelancer", orphanRemoval=true)
     */
    private $reserver;
    public function __construct()
    {
        $this->roles=array('ROLE_USER');
        $this->reserver = new ArrayCollection();
       //.........................................
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getDomaine(): ?string
    {
        return $this->domaine;
    }

    public function setDomaine(string $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): self
    {
        $this->mdp = $mdp;

        return $this;
    }
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function getSalt()
    {
        // The bcrypt and argon2i algorithms don't require a separate salt.
        // You *may* need a real salt if you choose a different encoder.
        return null;
    }
    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }
    public function getPassword()
    {
        return $this->mdp;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection|Reservation[]
     */
    public function getReserver(): Collection
    {
        return $this->reserver;
    }

    public function addReserver(Reservation $reserver): self
    {
        if (!$this->reserver->contains($reserver)) {
            $this->reserver[] = $reserver;
            $reserver->setFreelancer($this);
        }

        return $this;
    }

    public function removeReserver(Reservation $reserver): self
    {
        if ($this->reserver->contains($reserver)) {
            $this->reserver->removeElement($reserver);
            // set the owning side to null (unless already changed)
            if ($reserver->getFreelancer() === $this) {
                $reserver->setFreelancer(null);
            }
        }

        return $this;
    }




}
