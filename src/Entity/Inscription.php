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
     * @ORM\ManyToOne(targetEntity="App\Entity\Sortie", inversedBy="inscriptions")
     */
    private $sortie;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="inscriptions")
     */
    private $participant;

    /**
     * @return
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return
     */
    public function getDateInscription()
    {
        return $this->date_inscription;
    }

    /**
     * @param  $date_inscription
     */
    public function setDateInscription($date_inscription): void
    {
        $this->date_inscription = $date_inscription;
    }

    /**
     * @return Sortie
     */
    public function getSortie(): Sortie
    {
        return $this->sortie;
    }

    /**
     * @param Sortie $sortie
     */
    public function setSortie(Sortie $sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @return User
     */
    public function getParticipant(): User
    {
        return $this->participant;
    }

    /**
     * @param User $participant
     */
    public function setParticipant(User $participant): void
    {
        $this->participant = $participant;
    }


}
