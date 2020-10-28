<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\HopitalRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=HopitalRepository::class)
 */
class Hopital
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Nom can't be null")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Adresse can't be null")
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Contact can't be null")
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Email can't be null")
     * @Assert\Email(
     *  message = "Email '{{ value }}' is not valid!."
     *)
     */
    private $email;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Boite Postal can't be null")
     * 
     */
    private $boitePostal;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Fax can't be null")
     * 
     */
    private $fax;

    /**
     * @ORM\Column(type="blob")
     * @Assert\NotBlank(message = "Logo can't be null")
     * 
     */
    private $logo;

    /**
     * @ORM\Column(type="boolean")
     * 
     */
    private $statut;

    /**
     * @ORM\OneToMany(targetEntity=HopitalService::class, mappedBy="hopital")
     */
    private $hopitalServices;

    /**
     * @ORM\OneToMany(targetEntity=RendezVous::class, mappedBy="hopital")
     */
    private $rendezVouses;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="hopitals")
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    public function __construct()
    {
        $this->hopitalServices = new ArrayCollection();
        $this->rendezVouses = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getContact(): ?int
    {
        return $this->contact;
    }

    public function setContact(int $contact): self
    {
        $this->contact = $contact;

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

    public function getBoitePostal(): ?int
    {
        return $this->boitePostal;
    }

    public function setBoitePostal(int $boitePostal): self
    {
        $this->boitePostal = $boitePostal;

        return $this;
    }

    public function getFax(): ?string
    {
        return $this->fax;
    }

    public function setFax(string $fax): self
    {
        $this->fax = $fax;

        return $this;
    }

    public function getLogo()
    {
        if($this->logo){
            $data = stream_get_contents($this->logo);

            return base64_encode($data);
        }
       return;
    }

    public function setLogo($logo): self
    {
        $this->logo = $logo;

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

    /**
     * @return Collection|HopitalService[]
     */
    public function getHopitalServices(): Collection
    {
        return $this->hopitalServices;
    }

    public function addHopitalService(HopitalService $hopitalService): self
    {
        if (!$this->hopitalServices->contains($hopitalService)) {
            $this->hopitalServices[] = $hopitalService;
            $hopitalService->setHopital($this);
        }

        return $this;
    }

    public function removeHopitalService(HopitalService $hopitalService): self
    {
        if ($this->hopitalServices->contains($hopitalService)) {
            $this->hopitalServices->removeElement($hopitalService);
            // set the owning side to null (unless already changed)
            if ($hopitalService->getHopital() === $this) {
                $hopitalService->setHopital(null);
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
            $rendezVouse->setHopital($this);
        }

        return $this;
    }

    public function removeRendezVouse(RendezVous $rendezVouse): self
    {
        if ($this->rendezVouses->contains($rendezVouse)) {
            $this->rendezVouses->removeElement($rendezVouse);
            // set the owning side to null (unless already changed)
            if ($rendezVouse->getHopital() === $this) {
                $rendezVouse->setHopital(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }
}
