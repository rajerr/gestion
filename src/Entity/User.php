<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"ADMIN" = "User", "MEDECIN" = "Medecin", "PATIENT" = "Patient"})
 * 
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank(message = "Username can't be null")
     * 
     */
    protected $username;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message = "password can't be null")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "nom can't be null")
     */
    protected $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "prenom can't be null")
     */
    protected $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Genre can't be null")
     */
    protected $genre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Nationalité can't be null")
     */
    protected $nationalite;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Telephone can't be null")
     */
    protected $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Email can't be null")
     * @Assert\Email(
     *  message = "Email '{{ value }}' is not valid!."
     *)
     */
    protected $email;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $statut;

    /**
     * @ORM\ManyToOne(targetEntity=Profile::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    protected $profile;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Assert\NotBlank(message = "avatar can't be null")
     */
    protected $avatar;

    /**
     * @ORM\OneToMany(targetEntity=Hopital::class, mappedBy="user")
     */
    private $hopitals;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="user")
     */
    private $rendezVouses;

    /**
     * @ORM\OneToMany(targetEntity=Consultation::class, mappedBy="medecin")
     */
    private $consultations;

    public function __construct()
    {
        $this->hopitals = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
        $this->consultations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'. $this->profile->getLibelle();

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

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getNationalite(): ?string
    {
        return $this->nationalite;
    }

    public function setNationalite(string $nationalite): self
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getProfile(): ?Profile
    {
        return $this->profile;
    }

    public function setProfile(?Profile $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getAvatar()
    {
        if($this->avatar){
            $data = stream_get_contents($this->avatar);

            return base64_encode($data);
        }
       return;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Hopital[]
     */
    public function getHopitals(): Collection
    {
        return $this->hopitals;
    }

    public function addHopital(Hopital $hopital): self
    {
        if (!$this->hopitals->contains($hopital)) {
            $this->hopitals[] = $hopital;
            $hopital->setUser($this);
        }

        return $this;
    }

    public function removeHopital(Hopital $hopital): self
    {
        if ($this->hopitals->contains($hopital)) {
            $this->hopitals->removeElement($hopital);
            // set the owning side to null (unless already changed)
            if ($hopital->getUser() === $this) {
                $hopital->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RendezVous[]
     */
    public function getRendezVouses(): Collection
    {
        return $this->rendezVouses;
    }

    public function addRendezVouse(RendezVous $rendezVouse): self
    {
        if (!$this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses[] = $rendezVouse;
            $rendezVouse->setUser($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->removeElement($rendezVouse);
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getUser() === $this) {
                $rendezVouse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Consultation[]
     */
    public function getConsultations(): Collection
    {
        return $this->consultations;
    }

    public function addConsultation(Consultation $consultation): self
    {
        if (!$this->consultations->contains($consultation)) {
            $this->consultations[] = $consultation;
            $consultation->setMedecin($this);
        }

        return $this;
    }

    public function removeConsultation(Consultation $consultation): self
    {
        if ($this->consultations->contains($consultation)) {
            $this->consultations->removeElement($consultation);
            // set the owning side to null (unless already changed)
            if ($consultation->getMedecin() === $this) {
                $consultation->setMedecin(null);
            }
        }

        return $this;
    }
}
