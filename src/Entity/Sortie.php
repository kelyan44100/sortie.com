<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SortieRepository")
 */
class Sortie
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
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $datedebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbinscription;

    /**
     * @ORM\Column(type="date")
     */
    private $datecloture;

    /**
     * @ORM\Column(type="text", length=500, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etatsortie;

    /**
     * @ORM\Column(type="string", length=250, nullable=true)
     */
    private $urlphoto;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Participant")
     */
    private $organisateur;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu")
     */
    private $lieux_no_lieu;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat")
     */
    private $etats_no_etat;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToMany(targetEntity="App\Entity\Inscription")
     */
    private $inscriptions_no_inscription;

    /**
     * @ORM\Column(type="integer")
     * @ORM\ManyToOne(targetEntity="App\Entity\Site")
     */
    private $sites_no_site;

    /**
     * @return mixed
     */
    public function getSitesNoSite()
    {
        return $this->sites_no_site;
    }

    /**
     * @param mixed $sites_no_site
     */
    public function setSitesNoSite($sites_no_site): void
    {
        $this->sites_no_site = $sites_no_site;
    }

    /**
     * @return mixed
     */
    public function getInscriptionsNoInscription()
    {
        return $this->inscriptions_no_inscription;
    }

    /**
     * @param mixed $inscriptions_no_inscription
     */
    public function setInscriptionsNoInscription($inscriptions_no_inscription): void
    {
        $this->inscriptions_no_inscription = $inscriptions_no_inscription;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
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


    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNbinscription(): ?int
    {
        return $this->nbinscription;
    }

    public function setNbinscription(int $nbinscription): self
    {
        $this->nbinscription = $nbinscription;

        return $this;
    }


    public function getEtatsortie(): ?int
    {
        return $this->etatsortie;
    }

    public function setEtatsortie(int $etatsortie): self
    {
        $this->etatsortie = $etatsortie;

        return $this;
    }

    public function getUrlphoto(): ?string
    {
        return $this->urlphoto;
    }

    public function setUrlphoto(?string $urlphoto): self
    {
        $this->urlphoto = $urlphoto;

        return $this;
    }

    public function getOrganisateur(): ?int
    {
        return $this->organisateur;
    }

    public function setOrganisateur(int $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }

    public function getLieuxNoLieu(): ?int
    {
        return $this->lieux_no_lieu;
    }

    public function setLieuxNoLieu(int $lieux_no_lieu): self
    {
        $this->lieux_no_lieu = $lieux_no_lieu;

        return $this;
    }

    public function getEtatsNoEtat(): ?int
    {
        return $this->etats_no_etat;
    }

    public function setEtatsNoEtat(int $etats_no_etat): self
    {
        $this->etats_no_etat = $etats_no_etat;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * @param mixed $datedebut
     */
    public function setDatedebut($datedebut): void
    {
        $this->datedebut = $datedebut;
    }

    /**
     * @return mixed
     */
    public function getDatecloture()
    {
        return $this->datecloture;
    }

    /**
     * @param mixed $datecloture
     */
    public function setDatecloture($datecloture): void
    {
        $this->datecloture = $datecloture;
    }
}