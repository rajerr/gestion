<?php

namespace App\Entity;

use App\Repository\PrescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PrescriptionRepository::class)
 */
class Prescription
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
     * 
     */
    private $libelle;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message = "Date can't be null")
     * 
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message = "Description can't be null")
     * 
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Consultation::class, inversedBy="prescriptions")
     */
    private $consultation;

    /**
     * @ORM\OneToMany(targetEntity=Analyse::class, mappedBy="prescription")
     */
    private $analyses;

    /**
     * @ORM\OneToMany(targetEntity=Resultat::class, mappedBy="prescription")
     */
    private $resultats;

    /**
     * @ORM\OneToMany(targetEntity=Ordonnance::class, mappedBy="prescription")
     */
    private $ordonnances;

    public function __construct()
    {
        $this->analyses = new ArrayCollection();
        $this->resultats = new ArrayCollection();
        $this->ordonnances = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getConsultation(): ?Consultation
    {
        return $this->consultation;
    }

    public function setConsultation(?Consultation $consultation): self
    {
        $this->consultation = $consultation;

        return $this;
    }

    /**
     * @return Collection|Analyse[]
     */
    public function getAnalyses(): Collection
    {
        return $this->analyses;
    }

    public function addAnalysis(Analyse $analysis): self
    {
        if (!$this->analyses->contains($analysis)) {
            $this->analyses[] = $analysis;
            $analysis->setPrescription($this);
        }

        return $this;
    }

    public function removeAnalysis(Analyse $analysis): self
    {
        if ($this->analyses->contains($analysis)) {
            $this->analyses->removeElement($analysis);
            // set the owning side to null (unless already changed)
            if ($analysis->getPrescription() === $this) {
                $analysis->setPrescription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Resultat[]
     */
    public function getResultats(): Collection
    {
        return $this->resultats;
    }

    public function addResultat(Resultat $resultat): self
    {
        if (!$this->resultats->contains($resultat)) {
            $this->resultats[] = $resultat;
            $resultat->setPrescription($this);
        }

        return $this;
    }

    public function removeResultat(Resultat $resultat): self
    {
        if ($this->resultats->contains($resultat)) {
            $this->resultats->removeElement($resultat);
            // set the owning side to null (unless already changed)
            if ($resultat->getPrescription() === $this) {
                $resultat->setPrescription(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ordonnance[]
     */
    public function getOrdonnances(): Collection
    {
        return $this->ordonnances;
    }

    public function addOrdonnance(Ordonnance $ordonnance): self
    {
        if (!$this->ordonnances->contains($ordonnance)) {
            $this->ordonnances[] = $ordonnance;
            $ordonnance->setPrescription($this);
        }

        return $this;
    }

    public function removeOrdonnance(Ordonnance $ordonnance): self
    {
        if ($this->ordonnances->contains($ordonnance)) {
            $this->ordonnances->removeElement($ordonnance);
            // set the owning side to null (unless already changed)
            if ($ordonnance->getPrescription() === $this) {
                $ordonnance->setPrescription(null);
            }
        }

        return $this;
    }

}
