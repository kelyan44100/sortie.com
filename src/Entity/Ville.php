<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Regex("/^[[:alpha:]]([-' ]?[[:alpha:]])*$/", message="Entrer une ville valide!")
     */
    private $nom_ville;

    /**
     * @ORM\Column(type="string", length=10)
     * @Assert\Regex("/^[0-9]{5,5}$/", message="Entrer un code postal valide!")
     */
    private $code_postal;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Lieu",  cascade={"persist", "remove"}, mappedBy="ville")
     */
    private $lieux;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(string $nom_ville): self
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * @param ArrayCollection $lieux
     */
    public function setLieux(ArrayCollection $lieux): void
    {
        $this->lieux = $lieux;
    }


    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return[
            'cp' => $this->code_postal
        ];
    }
}
