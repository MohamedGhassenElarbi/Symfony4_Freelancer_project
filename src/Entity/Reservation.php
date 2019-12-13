<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Freelancer", inversedBy="reserver")
     * @ORM\JoinColumn(nullable=false)
     */
    private $freelancer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Tache", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_tache;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFreelancer(): ?Freelancer
    {
        return $this->freelancer;
    }

    public function setFreelancer(?Freelancer $freelancer): self
    {
        $this->freelancer = $freelancer;

        return $this;
    }

    public function getIdTache(): ?Tache
    {
        return $this->id_tache;
    }

    public function setIdTache(Tache $id_tache): self
    {
        $this->id_tache = $id_tache;

        return $this;
    }

   
}
