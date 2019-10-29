<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


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
    private $dateDebut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Assert\Regex("/^[0-9]*$/", message="Entrer une latitude valide!")
     */
    private $nbInscription;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="sorties")
     */
    private $organisateur;


    /**
     * @ORM\Column(type="date")
     */
    private $dateCloture;

    /**
     * @ORM\Column(type="text", length=500, nullable=true)
     */
    private $description;


    /**
     * @ORM\Column(type="text", length=500, nullable=true)
     */
    private $motifAnnulation;

    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $filePhoto;


    /**
     * @Assert\File(
     *     maxSize="2Mi",
     *  uploadErrorMessage="Le fichier n'a pas été correctement téléchargé",
     *     maxSizeMessage="Le fichier est trop lourd",
     *     )
     *
     */
    private $fileTempPhoto;


    /**
     * @var Lieu
     * @ORM\ManyToOne(targetEntity="App\Entity\Lieu")
     */
    private $lieu;

    /**
     * @var Etat
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat")
     */
    private $etat;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", cascade={"remove", "persist"}, mappedBy="sortie")
     */
    private $inscriptions;

    /**
     * @var Site
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="sorties")
     */
    private $site;


    /**
     * Sortie constructor.
     */
    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }


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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param  $dateDebut
     */
    public function setDateDebut($dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return
     */
    public function getDateCloture()
    {
        return $this->dateCloture;
    }

    /**
     * @param  $dateCloture
     */
    public function setDateCloture($dateCloture): void
    {
        $this->dateCloture = $dateCloture;
    }


    /**
     * @return mixed
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param mixed $duree
     */
    public function setDuree($duree): void
    {
        $this->duree = $duree;
    }

    /**
     * @return mixed
     */
    public function getNbInscription()
    {
        return $this->nbInscription;
    }

    /**
     * @param mixed $nbInscription
     */
    public function setNbInscription($nbInscription): void
    {
        $this->nbInscription = $nbInscription;
    }

    /**
     * @return User
     */
    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    /**
     * @param User $organisateur
     */
    public function setOrganisateur(?User $organisateur): void
    {
        $this->organisateur = $organisateur;
    }


    /**
     * @return
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param  $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getMotifAnnulation()
    {
        return $this->motifAnnulation;
    }

    /**
     * @param mixed $motifAnnulation
     */
    public function setMotifAnnulation($motifAnnulation): void
    {
        $this->motifAnnulation = $motifAnnulation;
    }



    /**
     * @return
     */
    public function getFilePhoto()
    {
        return $this->filePhoto;
    }

    /**
     * @param  $filePhoto
     */
    public function setFilePhoto($filePhoto): void
    {
        $this->filePhoto = $filePhoto;
    }

    /**
     * @return
     */
    public function getFileTempPhoto()
    {
        return $this->fileTempPhoto;
    }

    /**
     * @param  $fileTempPhoto
     */
    public function setFileTempPhoto($fileTempPhoto): void
    {
        $this->fileTempPhoto = $fileTempPhoto;
    }

    /**
     * @return Lieu
     */
    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    /**
     * @param Lieu $lieu
     */
    public function setLieu(?Lieu $lieu): void
    {
        $this->lieu = $lieu;
    }

    /**
     * @return Etat
     */
    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    /**
     * @param Etat $etat
     */
    public function setEtat(?Etat $etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return ArrayCollection
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    /**
     * @param ArrayCollection $inscriptions
     */
    public function setInscriptions(ArrayCollection $inscriptions): void
    {
        $this->inscriptions = $inscriptions;
    }

    /**
     * @return Site
     */
    public function getSite(): ?Site
    {
        return $this->site;
    }

    /**
     * @param Site $site
     */
    public function setSite(?Site $site): void
    {
        $this->site = $site;
    }
}
