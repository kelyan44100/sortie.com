<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 */
class Site
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_site;

    /**
     * @var ArrayCollection
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Sorties_no_sortie;

    /**
     * @var ArrayCollection
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="App\Entity\Participant")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Participants_no_participant;

    /**
     * Site constructor.
     * @param $id
     * @param $nom_site
     * @param ArrayCollection $Sorties_no_sortie
     * @param ArrayCollection $Participants_no_participant
     */
    public function __construct($id, $nom_site, ArrayCollection $Sorties_no_sortie, ArrayCollection $Participants_no_participant)
    {
        $this->id = $id;
        $this->nom_site = $nom_site;
        $this->Sorties_no_sortie = $Sorties_no_sortie;
        $this->Participants_no_participant = $Participants_no_participant;
    }

    /**
     * @return mixed
     */
    public function getSortiesNoSortie()
    {
        return $this->Sorties_no_sortie;
    }

    /**
     * @param mixed $Sorties_no_sortie
     */
    public function setSortiesNoSortie($Sorties_no_sortie): void
    {
        $this->Sorties_no_sortie = $Sorties_no_sortie;
    }

    /**
     * @return mixed
     */
    public function getParticipantsNoParticipant()
    {
        return $this->Participants_no_participant;
    }

    /**
     * @param mixed $Participants_no_participant
     */
    public function setParticipantsNoParticipant($Participants_no_participant): void
    {
        $this->Participants_no_participant = $Participants_no_participant;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSite(): ?string
    {
        return $this->nom_site;
    }

    public function setNomSite(string $nom_site): self
    {
        $this->nom_site = $nom_site;

        return $this;
    }

    public function __toString()
    {
        return $this->getNomSite();
    }


}
