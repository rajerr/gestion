<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ConsultationRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ConsultationRepository::class)
 */
class Consultation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Libelle can't be null")
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     * 
     */
    private $date;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Poids can't be null")
     */
    private $poids;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message = "Temperature can't be null")
     */
    private $temperature;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message = "Tension can't be null")
     */
    private $tension;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Diagnostique can't be null")
     */
    private $diagnostique;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="consultations")
     */
    private $patient;

    /**
     * @ORM\OneToMany(targetEntity=Prescription::class, mappedBy="consultation")
     */
    private $prescriptions;

    /**
     * @ORM\OneToMany(targetEntity=Suivi::class, mappedBy="consultation")
     */
    private $suivis;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="consultations")
     */
    private $medecin;

    public function __construct()
    {
        $this->prescriptions = new ArrayCollection();
        $this->suivis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPoids(): ?int
    {
        return $this->poids;
    }

    public function setPoids(int $poids): self
    {
        $this->poids = $poids;

        return $this;
    }

    public function getTemperature(): ?int
    {
        return $this->temperature;
    }

    public function setTemperature(int $temperature): self
    {
        $this->temperature = $temperature;

        return $this;
    }

    public function getTension(): ?string
    {
        return $this->tension;
    }

    public function setTension(string $tension): self
    {
        $this->tension = $tension;

        return $this;
    }

    public function getDiagnostique(): ?string
    {
        return $this->diagnostique;
    }

    public function setDiagnostique(string $diagnostique): self
    {
        $this->diagnostique = $diagnostique;

        return $this;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * @return Collection|Prescription[]
     */
    public function getPrescriptions(): Collection
    {
        return $this->prescriptions;
    }

    public function addPrescription(Prescription $prescription): self
    {
        if (!$this->prescriptions->contains($prescription)) {
            $this->prescriptions[] = $prescription;
            $prescription->setConsultation($this);
        }

        return $this;
    }

    public function removePrescription(Prescription $prescription): self
    {
        if ($this->prescriptions->contains($prescription)) {
            $this->prescriptions->removeElement($prescription);
            // set the owning side to null (unless already changed)
            if ($prescription->getConsultation() === $this) {
                $prescription->setConsultation(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Suivi[]
     */
    public function getSuivis(): Collection
    {
        return $this->suivis;
    }

    public function addSuivi(Suivi $suivi): self
    {
        if (!$this->suivis->contains($suivi)) {
            $this->suivis[] = $suivi;
            $suivi->setConsultation($this);
        }

        return $this;
    }

    public function removeSuivi(Suivi $suivi): self
    {
        if ($this->suivis->contains($suivi)) {
            $this->suivis->removeElement($suivi);
            // set the owning side to null (unless already changed)
            if ($suivi->getConsultation() === $this) {
                $suivi->setConsultation(null);
            }
        }

        return $this;
    }

    public function getMedecin(): ?User
    {
        return $this->medecin;
    }

    public function setMedecin(?User $medecin): self
    {
        $this->medecin = $medecin;

        return $this;
    }
}
