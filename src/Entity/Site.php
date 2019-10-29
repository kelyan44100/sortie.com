<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
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
     * @Assert\Regex("/^[[:alpha:]]([-' ]?[[:alpha:]])*$/", message="Entrer un site valide!")
     */
    private $nom_site;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="site")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sorties;

    /**
     * @var  ArrayCollection
     * @ORM\OneToMany(targetEntity="\App\Entity\User", mappedBy="site" )
     */
    private $users;


    public function __construct()
    {
        $this->sorties = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSorties()
    {
        return $this->sorties;
    }

    /**
     * @param $sorties
     */
    public function setSorties($sorties): void
    {
        $this->sorties = $sorties;
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

    /**
     * @return ArrayCollection
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     */
    public function setUsers(ArrayCollection $users): void
    {
        $this->users = $users;
    }


}
