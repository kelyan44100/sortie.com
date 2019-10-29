<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity("email", message="Email déjà pris")
 * @UniqueEntity("pseudo", message="Peudo déjà pris")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Regex("\^[a-zA-Z0-9_]{3,16}$\", message="Entrer un pseudo valide!")
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Your username must be at least {{ limit }} characters long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} characters"
     * )
     * @Assert\Regex(pattern="/^[a-z0-9_-]+$/i", message="Your username must contains only letters, numbers, underscores and dashes!")
     *
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Your username must be at least {{ limit }} characters long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} characters"
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Length(
     *      min = 4,
     *      max = 30,
     *      minMessage = "Your username must be at least {{ limit }} characters long",
     *      maxMessage = "Your username cannot be longer than {{ limit }} characters"
     * )
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=180)
     * @Assert\Length(min = 10,  minMessage = "min_lenght")
     * @Assert\Regex("/\^(\d\d\s){4}(\d\d)$\/" , message="Entrer un numero de telephone valide!")
     *
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex("/^[^\W][a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\@[a-zA-Z0-9_]+(\.[a-zA-Z0-9_]+)*\.[a-zA-Z]{2,4}$/" , message="Entrer un email valide!")
     */
    private $email;


    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Sortie", mappedBy="organisateur")
     */
    private $sorties;

    /**
     * @var array
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Ce chant est requis")
     * @Assert\Length(
     *      min = 6,
     *      max = 4096,
     *      minMessage = "Vôtre mot de passe doit contenir {{ limit }} au minimum",
     *      maxMessage = "Vôtre mot de passe doit contenir {{ limit }} au maximum"
     * )
     */
    private $password;


    /**
     * @var Site
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="users")
     */
    private $site;


    /**
     * @ORM\Column(type="text", length=255, nullable=true)
     */
    private $file;


    /**
     * @Assert\File(
     *     maxSize="2Mi",
     *  uploadErrorMessage="Le fichier n'a pas été correctement téléchargé",
     *     maxSizeMessage="Le fichier est trop lourd",
     *     )
     *
     */
    private $fileTemp;

    /**
     * @var bool
     * @ORM\Column( type="boolean", options={"default":true})
     */
    private $actif;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Inscription", mappedBy="participant")
     */
    private $inscriptions;

    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->sorties = new ArrayCollection();
    }


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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * @param mixed $pseudo
     */
    public function setPseudo($pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone): void
    {
        $this->telephone = $telephone;
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



    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile($file): void
    {
        $this->file = $file;
    }

    /**
     * @return mixed
     */
    public function getFileTemp()
    {
        return $this->fileTemp;
    }

    /**
     * @param mixed $fileTemp
     */
    public function setFileTemp($fileTemp): void
    {
        $this->fileTemp = $fileTemp;
    }



    /**
     * @return bool
     */
    public function isActif(): ?bool
    {
        return $this->actif;
    }



    /**
     * @param bool $actif
     */
    public function setActif(bool $actif): void
    {
        $this->actif = $actif;
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
     * @return ArrayCollection
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    /**
     * @param ArrayCollection $sorties
     */
    public function setSorties(ArrayCollection $sorties): void
    {
        $this->sorties = $sorties;
    }



    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function __toString()
    {
return $this->getNom();
    }

}
