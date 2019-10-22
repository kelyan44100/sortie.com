<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InscriptionRepository")
 */
class Inscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;


    /**
     * @var Sortie
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="inscriptions_no_inscription")
     */
    private $sorties_no_sortie;

    /**
     * @ORM\Column(type="integer")
     */
    private $participants_no_participant;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    public function getSortiesNoSortie(): Sortie
    {
        return $this->sorties_no_sortie;
    }

    public function setSortiesNoSortie(Sortie $sorties_no_sortie): self
    {
        $this->sorties_no_sortie = $sorties_no_sortie;

        return $this;
    }

    public function getParticipantsNoParticipant(): ?int
    {
        return $this->participants_no_participant;
    }

    public function setParticipantsNoParticipant(int $participants_no_participant): self
    {
        $this->participants_no_participant = $participants_no_participant;

        return $this;
    }
}
